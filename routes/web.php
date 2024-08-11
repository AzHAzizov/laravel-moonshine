<?php
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;



Route::get('/getUpdates', function() {
    while(true) {
        $updates = Telegram::getUpdates();
        dd($updates);
        // foreach ($updates as $update) {
        //     $message = $update->getMessage();
        //     if ($message) {
        //         $chatId = $message->getChat()->getId();
        //         $text = $message->getText();

        //         // Обработка сообщения
        //         Telegram::sendMessage([
        //             'chat_id' => $chatId,
        //             'text' => "Вы отправили: $text",
        //         ]);
        //     }
        // }
    }
});



