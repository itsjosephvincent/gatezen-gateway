<?php

namespace App\Repositories;

use App\Interface\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{
    public function findUserById($userId)
    {
        return User::with([
            'language',
            'address',
            'address.countries',
        ])
            ->findOrFail($userId);
    }

    public function findUserByEmail($email)
    {
        return User::with(['roles'])->where(function ($query) use ($email): void {
            $query->where('email', $email)
                ->orWhere('secondary_email', $email)
                ->orWhere('third_email', $email);
        })
            ->first();
    }

    public function findUserByFirstnameLastname($firstname, $lastname)
    {
        return User::where('firstname', $firstname)
            ->where('lastname', $lastname)
            ->first();
    }

    public function findUser($email, $firstname, $lastname)
    {
        $userByEmail = User::with(['roles'])
            ->where(function ($query) use ($email): void {
                $query->where('email', $email)
                    ->orWhere('secondary_email', $email)
                    ->orWhere('third_email', $email);
            })
            ->first();

        if ($userByEmail) {
            return ['user' => $userByEmail, 'method' => 'email'];
        }

        $userByName = User::with(['roles'])
            ->where('firstname', $firstname)
            ->where('lastname', $lastname)
            ->first();

        if ($userByName) {
            return ['user' => $userByName, 'method' => 'name'];
        }

        return null;
    }

    public function storeSecondaryEmail($email, $userId)
    {
        $user = User::findOrFail($userId);
        $user->secondary_email = $email;
        $user->save();

        return $user->fresh();
    }

    public function storeThirdEmail($email, $userId)
    {
        $user = User::findOrFail($userId);
        $user->third_email = $email;
        $user->save();

        return $user->fresh();
    }

    public function storeUser($payload)
    {
        $user = new User();
        $user->firstname = $payload->firstname;
        $user->middlename = $payload->middlename ?? null;
        $user->lastname = $payload->lastname;
        $user->mobile = $payload->mobile ?? null;
        $user->email = $payload->email;
        $user->password = Hash::make($payload->password);
        $user->language_id = $payload->language_id ?? 1;
        $user->save();

        $user->assignRole('Partner');

        return $user->fresh();
    }

    public function updateUser($payload, $userId)
    {
        $user = User::findOrFail($userId);
        $user->firstname = $payload->firstname;
        $user->middlename = $payload->middlename ?? $user->middlename;
        $user->lastname = $payload->lastname;
        $user->mobile = $payload->mobile ?? $user->mobile;
        $user->email = $payload->email;
        $user->language_id = $payload->language_id ?? $user->language_id;
        $user->save();

        return $user->fresh();
    }

    public function updatePassword($payload, $userId)
    {
        $user = User::findOrFail($userId);
        $user->password = Hash::make($payload->new_password);
        $user->save();

        return $user->fresh();
    }

    public function blockUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_blocked = true;
        $user->save();

        return $user->fresh();
    }

    public function unblockUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_blocked = false;
        $user->save();

        return $user->fresh();
    }

    public function createUserFromSync($userData)
    {
        $user = new User();
        $user->firstname = trim($userData['FirstName']);
        $user->lastname = trim($userData['LastName']);
        $user->mobile = isset($userData['MobileNumber']) ? trim($userData['MobileNumber']) : null;
        $user->email = strtolower($userData['Email']);
        $user->password = Hash::make(Str::random(12));
        $user->save();

        return $user->fresh();
    }
}
