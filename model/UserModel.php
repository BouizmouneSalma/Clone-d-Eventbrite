<?php

interface UserModel
{
    public function save(User $user): bool;

    public function verifyUser(User $user): array|bool;

    public function logout (): void;

    public function getAllUsers(): array ;
        
}
?>