<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(RegisterUserRequest $request)
    {
        $payload = $request->all();
        $payload['password'] = Hash::make($payload['password']);

        $user = User::create($payload);

        return $this->success([
            'user' =>$user,
            'token' => $user->createToken($payload['token_name'])->plainTextToken
        ],'Usuario Criado!');
    }

    public function login(UserLoginRequest $request)
    {
        $payload = $request->all();

        if (!Auth::attempt($payload)) {
            return $this->error('Credentials not match', 401);
        }

        $user = auth()->user();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API token')->plainTextToken
//            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {

        $requestToken = $request->header('authorization');
        $personalAccessToken = new PersonalAccessToken();
        $token = $personalAccessToken->findToken(str_replace('Bearer ','',$requestToken));

        $token->delete();

//        $user = auth()->user();
//        $user->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
