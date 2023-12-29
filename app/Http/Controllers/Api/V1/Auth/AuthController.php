<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\V1\AbstractApiController;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;

class AuthController extends AbstractApiController
{
    private bool $loginProcessMethod = false;
    private string $token = '';

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Authorization user by email and password to get Bearer Token
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $this->loginProcessMethod = true;
        $credentials = $request->all();
        return $this->loginProcess($credentials);
    }

    /**
     * Get autorization user data
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user_data = auth()->user();

        return $this->responseJSON(
            __('auth.response.200.me'),
            200,
            $user_data != null ? $user_data->toArray() : []
        );
    }

    /**
     * User logout and clear a authorization token
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return $this->responseJSON(__('auth.response.200.logout'));
    }

    /**
     * Refresh access token
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            $this->token = auth()->refresh();

            if (!empty($this->token)) {
                return $this->responseJSON(
                    __('auth.response.200.refresh_token'),
                    200,
                    $this->getTokenData()
                );
            }

            return $this->responseJSON(__('auth.response.422.token'), 422, []);
        } catch (TokenBlacklistedException | JWTException $err) {
            return $this->responseJSON($err->getMessage(), 422, []);
        }
    }

    /**
     * Method login user
     *
     * @param array $credentials
     *
     * @return JsonResponse
     */
    private function loginProcess(array $credentials): JsonResponse
    {
        if (!$this->token = auth()->attempt($credentials)) {
            return $this->responseJSON(__('auth.response.401.login'), 401);
        }

        return $this->responseJSON(
            $this->loginProcessMethod ? __('auth.response.200.login') : __('auth.response.200.register'),
            200,
            $this->getTokenData(),
        );
    }

    /**
     * Get current user token
     *
     * @return array
     */
    protected function getTokenData(): array
    {
        return [
            'access_token' => $this->token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ];
    }
}
