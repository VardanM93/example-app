<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class AuthController extends Controller
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
     * @param RegisterFormRequest $request
     * @return JsonResponse
     */
    public function register(RegisterFormRequest $request):JsonResponse
    {
        if(auth()->user()->tokens()){
            $this->logout();
        }

        $user = $this->userRepository->createEntity(
            $request->name,
            $request->email,
            $request->password
        );


        $user->token = $user->createToken('API Token')->plainTextToken;



        return response()->json(new UserResource($user),
            ResponseAlias::HTTP_CREATED);

    }




    public  function  login(LoginFormRequest $request)
    {


       $user = $this->userRepository->checkEntity($request->email);


        if (!$user || !Hash::check($request->password, $user->password))
        {
            return response([
                'message' => 'bad credentials'
            ],ResponseAlias::HTTP_UNAUTHORIZED);
        }



        $token = $user->createToken('API Token')->plainTextToken;


        return response()->json([
            'data' => $token
        ],
            ResponseAlias::HTTP_OK);
    }

    /**
     * @return string[]
     */
    public function logout(): array
    {

        auth()->user()->tokens()->delete();

        return [
            'massage' => 'Logged out'
        ];
    }
}
