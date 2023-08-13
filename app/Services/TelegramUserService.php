<?php


namespace App\Services;


use App\Models\TelegramUser;

class TelegramUserService
{
    static public function storeUser($userId, $firstName, $lastName, $username)
    {
        try {
            $user = TelegramUser::where('telegramId', $userId)->first();

            if (!$user) {
                $newUser = new TelegramUser;
                $newUser->telegramId = $userId;
                $newUser->firstName = $firstName;
                $newUser->lastName = $lastName;
                $newUser->username = $username;
                $newUser->save();
            }
        }  catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }
}
