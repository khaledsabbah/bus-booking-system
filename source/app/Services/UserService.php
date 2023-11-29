<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;


class UserService extends BaseService
{
    protected $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function store(array $data)
    {
        $data['plain_password'] = $data['password'];
        $data['password'] = Hash::make($data['password']);

        $user = $this->repository->store($data);

        return $user;
    }

    public function update(int $id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = $this->repository->update($id, $data);

        return $user;
    }

    public function removeProfilePicture(User $user)
    {
        return $this->repository->removeProfilePicture($user);
    }

    public function findByEmail(string $email)
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

}

