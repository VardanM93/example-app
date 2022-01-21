<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use function auth;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 *
 *
 */
class AuthController extends BaseController
{
    /**
     * @var UserRepository
     */
    private  UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * User register
     * @param RegisterRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|object
     */
    public function register(RegisterRequest $request)
    {

        $user = $this->userRepository->createEntity(
            $request->name,
            $request->email,
            $request->password
        );

        $user->token = $user->createToken('API Token')->plainTextToken;

        return $this->response(new UserResource($user))
            ->setStatusCode(Response::HTTP_CREATED);

    }

    /**
     * User login
     * @param LoginRequest $request
     * @return JsonResponse|object
     */
    public  function  login(LoginRequest $request)
    {

       $user = $this->userRepository->checkEntity($request->email);

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return $this->response(new MessageResource(
                [
                    'message' => 'bad credentials'
                ]
             )
            )->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        $user->token = $user->createToken('API Token')->plainTextToken;

        return $this->response(new UserResource($user))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * User logout
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\Response|object
     */
    public function logout()
    {

        Auth::user()->tokens()->delete();

        return $this->response(new MessageResource(
            [
                'message' => 'Logged out'
            ]
            )
        )->setStatusCode(Response::HTTP_OK);

    }
}
