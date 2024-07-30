<?php

namespace App\Services;

use App\Exceptions\PasswordReset\InvalidCurrentPasswordException;
use App\Http\Resources\UserResource;
use App\Interface\Repositories\AddressRepositoryInterface;
use App\Interface\Repositories\UserRepositoryInterface;
use App\Interface\Services\UserServiceInterface;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    private $userRepository;

    private $addressRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AddressRepositoryInterface $addressRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
    }

    public function getUserById($user)
    {
        $user = $this->userRepository->findUserById($user->id);

        return new UserResource($user);
    }

    public function getUserByEmail($email)
    {
        $user = $this->userRepository->findUserByEmail($email);

        return new UserResource($user);
    }

    public function storeUser($payload)
    {
        $user = $this->userRepository->storeUser($payload);

        return new UserResource($user);
    }

    public function editUser($payload, $user)
    {
        $address = $this->addressRepository->findAddressByUser($user);
        if (! $address) {
            $this->addressRepository->storeAddress($payload, $user);
        }
        $this->addressRepository->updateAddress($payload, $user);
        $this->userRepository->updateUser($payload, $user->id);
        $user = $this->userRepository->findUserById($user->id);

        return new UserResource($user);
    }

    public function editPassword($payload, $user)
    {
        $currentUser = $this->userRepository->findUserById($user->id);

        if ($currentUser) {
            if (! Hash::check($payload->current_password, $currentUser->password)) {
                throw new InvalidCurrentPasswordException();
            }
            $this->userRepository->updatePassword($payload, $currentUser->id);
        }

        return new UserResource($currentUser);
    }
}
