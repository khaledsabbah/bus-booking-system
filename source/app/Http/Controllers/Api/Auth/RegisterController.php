<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Services\UserService;
use App\Traits\ResponseTrait;

/**
 * @group Auth
 */
class RegisterController extends Controller
{
    use ResponseTrait;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register
     *
     * To authenticate your SPA,
     * your SPA's "login" page should first make a request to the `/sanctum/csrf-cookie` endpoint
     * to initialize CSRF protection for the application.
     * @bodyParam name string required Example:john
     * @bodyParam email string required Example:khaled@voyage.com
     * @bodyParam password string required Example:aaA1$2211
     * @bodyParam password_confirmation string required Example:aaA1$2211
     * @bodyParam role_id int nullable Example:1
     * @bodyParam profile_picture binary nullable
     *
     * @apiResourceAdditional message="user have created successfully"
     *
     * @header Content-Type application/x-www-form-urlencoded
     * @response {
     *      "data": {
     *          "message": "User have created successfully",
     *          "data": null,
     *      }
     *  }
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->userService->store($validatedData);
        event(new NewRegisteredUserEvent($user));

        return $this->respondCreated(
            trans('messages.model.store', ['model' => 'User']).". ".
            trans('messages.business.registered', ['email' => $request->email]),
        );
    }

}
