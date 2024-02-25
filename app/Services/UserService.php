<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {

    }
    public function getAllUsers($paginator)
    {
        return $this->userRepository->getAllUsers($paginator);
    }
}
