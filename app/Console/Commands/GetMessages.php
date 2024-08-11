<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Keyboard\Keyboard;
class GetMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->getUpdates();
    }

    public function getUpdates()
    {
        $updates = Telegram::getUpdates();
        foreach($updates as $update) {
            $this->routeUpdate($update);
        }
    }

    protected function routeUpdate($update)
    {
        $chat = $update->getMessage()->getChat(); 
        $this->userIdentify($chat->id, $chat->first_name);
        $user = Auth::user();
        $message = $update->getMessage();
 
        if ($message->has('contact')) {
            $contact = $message->getContact();
            $phoneNumber = $contact->getPhoneNumber();
            $user->update(['phone' => $phoneNumber]);
        }elseif(empty($user->phone)) {
            return $this->askContact();
        }

        $this->saveMessage($update);
    }

    private function saveMessage($update) {

        if(empty($update->getMessage()->text)) return;

        Auth::user()->messages()->create([
            'body' => serialize($update),
            'text' => $update->getMessage()->text,
        ]);
    }


    private function userIdentify(int $chat_id, string $firstName) {
        $user = User::where('chat_id', $chat_id)->first();
        if(empty($user->id)) {
            $user = User::create([
                'chat_id' => $chat_id,
                'name' => $firstName,
            ]);
        }
        Auth::loginUsingId($user->id);
    }


    public function askContact() {
        $btn = Keyboard::button([
            'text' => 'Share my phone number',
            'request_contact' => true
        ]);
        $keyboard = Keyboard::make([
            'keyboard' => [[$btn]],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
        Telegram::sendMessage([
            'chat_id' => Auth::user()->chat_id,
            'text' => 'I need your contact to get your ID. Please click the Share Contact button below.',
            'reply_markup' => $keyboard
        ]);
    }
}
