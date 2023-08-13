<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use App\Services\TelegramUserService;
use Exception;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $telegram = new Api(config('telegram.bot_token'));

            $update = $telegram->getWebhookUpdate();
            $message = $update->getMessage();
            $chatId = $message->getChat()->getId();
            $userId = $message->getFrom()->getId();
            $firstName = $message->getFrom()->getFirstName();
            $lastName = $message->getFrom()->getLastName();
            $username = $message->getFrom()->getUsername();

            if ($message->getText() == '/start@TrelloStatBot') {

                TelegramUserService::storeUser($userId, $firstName, $lastName, $username);

                $response = "Привет, $firstName! Добро пожаловать!";
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $response,
                ]);
            }
            return response()->json(['message' => 'Success']);
        } catch (Exception $e) {
        }
    }

    public function sendTrelloEvent(Request $request)
    {
        $model = $request->input('model')['name'];
        $action = $request->input('action');
        $card = $action['data']['card']['name'];
        $listBefore = $action['data']['listBefore']['name'];
        $listAfter = $action['data']['listAfter']['name'];
        try {
            $telegram = new Api(config('telegram.bot_token'));
            //$response = "trello";
            $response = "В дошці $model була переміщена картка $card з колонки $listBefore до колонки $listAfter";
            $telegram->sendMessage([
                'chat_id' => -1001833203461,
                'text' => $response,
            ]);
        } catch (TelegramSDKException $e) {
        }
        return response($action, 200);
    }
}
