<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function sendPasswordResetLink($email)
    {
        $response = Password::sendResetLink(['email' => $email]);

        return $response === Password::RESET_LINK_SENT;
    }

    public function resetPassword($data)
    {
        $resetResponse = Password::reset(
            $data,
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $resetResponse === Password::PASSWORD_RESET;
    }
}
