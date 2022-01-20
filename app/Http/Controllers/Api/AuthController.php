<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
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
            return $this->responseJson(['message' => 'bad credentials'])
            ->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }



        $token = $user->createToken('API Token')->plainTextToken;


        return $this->responseJson(
            [
                'message' => 'logged in',
                'token' => $token
            ]
        )->setStatusCode(Response::HTTP_OK);
    }

    /**
     * User logout
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {

        auth()->user()->tokens()->delete();

        return $this->responseJson(
            [
                'message' => 'Logged out'
            ]
        )->setStatusCode(Response::HTTP_OK);

    }
}
