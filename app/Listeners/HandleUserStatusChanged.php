<?php

namespace App\Listeners;

use Telegram\Bot\Laravel\Facades\Telegram;


class HandleUserStatusChanged
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        $status = $user->active ? 'active' : 'inactive';

        Telegram::sendMessage([
            'chat_id' => $user->chat_id,
            'text' => 'Your status has changed to: ' . $status,
        ]);
    }
}
