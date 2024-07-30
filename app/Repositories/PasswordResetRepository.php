<?php

namespace App\Repositories;

use App\Interface\Repositories\PasswordResetRepositoryInterface;
use App\Models\PasswordReset;
use Carbon\Carbon;

class PasswordResetRepository implements PasswordResetRepositoryInterface
{
    public function store($email, $token)
    {
        $passwordReset = new PasswordReset();
        $passwordReset->email = $email;
        $passwordReset->token = $token;
        $passwordReset->expires_at = Carbon::now()->addMinutes(30);
        $passwordReset->save();

        return $passwordReset->fresh();
    }

    public function findByToken($token)
    {
        return PasswordReset::where('token', $token)->first();
    }

    public function delete($token)
    {
        return PasswordReset::where('token', $token)->delete();
    }
}
