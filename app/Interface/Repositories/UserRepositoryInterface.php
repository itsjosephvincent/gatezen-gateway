<?php

namespace App\Interface\Repositories;

interface UserRepositoryInterface
{
    public function findUserById(int $userId);

    public function findUserByEmail(string $email);

    public function findUserByFirstnameLastname($firstname, $lastname);

    public function findUser($email, $firstname, $lastname);

    public function storeUser(object $payload);

    public function storeSecondaryEmail($email, $userId);

    public function storeThirdEmail($email, $userId);

    public function updateUser(object $payload, int $userId);

    public function updatePassword(object $payload, int $userId);

    public function blockUser($userId);

    public function unblockUser($userId);

    public function createUserFromSync($userData);
}
