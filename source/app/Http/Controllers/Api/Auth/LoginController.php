<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Services\AuthService;

/**
 * @group Auth
 */
class LoginController extends Controller
{
    use ResponseTrait;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login
     *
     * To authenticate your SPA,
     * your SPA's "login" page should first make a request to the `/sanctum/csrf-cookie` endpoint
     * to initialize CSRF protection for the application.
     * @bodyParam email string required Example:admin@b5digital.dk
     * @bodyParam password string required Example:aaA1$2211
     * @response {
     *      "data": {
     *          "message": "You have logged in successfully",
     *          "data": null,
     *      }
     *  }
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $roleId = $request->input('roleId');

        $this->authService->authenticate($credentials, $roleId);

        return $this->respondWithSuccess(
            trans('messages.login.success'),
        );
    }

    /**
     * Logout
     *
     * @response {
     *      "data": {
     *          "message": "You have logged out successfully",
     *          "data": null,
     *      }
     *  }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->respondWithSuccess(trans('messages.logout.success'));
    }

    /**
     * Create Testing Token
     *
     * @bodyParam email string required Example:admin@b5digital.dk
     * @bodyParam password string required Example:aaA1$2211
     * @bodyParam roleId string required Example: "AGENCY_ADMIN" fetched from List Roles API
     * @response {
     *      "data": {
     *          "access_token": "<<ACCESS_TOKEN>>",
     *      }
     *  }
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTestingToken(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $roleId = $request->input('roleId');

        $access_token = $this->authService->createTestingToken($credentials, $roleId);

        return $this->respondWithSuccess(
            trans('messages.login.success'),
            ['access_token' => $access_token]
        );
    }
}
