<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class AuthController extends ApiController
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * Register an user.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $params = $request->validated();
        $data = $this->repository->create($params);

        return $this->success($data);
    }

    /**
     * @throws RepositoryException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $rememberMe = false;
        if (isset($data['remember_me'])) {
            $rememberMe = (bool)$data['remember_me'];
            unset($data['remember_me']);
        }

        /** @var User $user */
        $user = $this->repository->getByUsername( $data['user_name']);

        if (!$user) {
            return $this->error(__('auth.account.not_exist'), Response::HTTP_FORBIDDEN);
        }

        if (!Hash::check($data['password'], $user->password)) {
            return $this->error(__('auth.password.incorrect'), Response::HTTP_FORBIDDEN);
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($rememberMe) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return $this->success([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user,
        ]);
    }

    /**
     * Get the authenticated user.
     *
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        return $this->success(request()->user());
    }

    /**
     * Check valid user (uses when user navigate on frontend).
     *
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        $check = Auth::guard('api')->check();

        if (!$check) {
            return $this->error(__('auth.account.token_expired'), 403);
        }

        return $this->success();
    }

    /**
     * Logout user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = request()->user();

        $token = $user->token();
        if ($token instanceof \Laravel\Passport\Token) {
            $token->revoke();
        }

        return $this->success([], [], __('auth.logout.success'));
    }
}
