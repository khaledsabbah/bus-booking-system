<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;

class AuthService
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function authenticate(array $credentials, $loginCode=null)
    {
        if (! auth()->attempt($credentials)) {
            throw new AuthenticationException(__('auth.failed'));
        }

        $credentials['is_active'] = 1;

        if (! auth()->attempt($credentials)) {
            throw new AuthenticationException(__('auth.inactive'));
        }
    }

    public function createTestingToken(array $credentials)
    {
        if ($this->validateCredentials($credentials)){
            $user = $this->userService->findByEmail($credentials['email']);
            $token = $user->createToken("testing_token")->plainTextToken;
            return $token;
        }
    }
    public function validateCredentials(array $credentials)
    {
        $user = $this->userService->findByEmail($credentials['email']);
        if (! $user || ! auth()->validate($credentials)) {
            throw new AuthenticationException(__('auth.failed'));
        }

        $credentials['is_active'] = 1;

        if (! auth()->validate($credentials)) {
            throw new AuthenticationException(__('auth.inactive'));
        }
        return true;
    }
}
