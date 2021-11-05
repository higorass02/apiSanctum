<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ApiResponser;
    public function authenticate(UserLoginRequest $request)
    {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            //return redirect()->intended('dasboard');
            return $this->success([],'Autenticado com sucesso!');
        }

        return $this->error('Credentials not match', 401);
    }
}
