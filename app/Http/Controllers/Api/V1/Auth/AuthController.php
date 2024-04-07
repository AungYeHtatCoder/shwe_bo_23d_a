<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginRequest $request)
    {
        $request->validated($request->all());
        $credentials = $request->only('phone', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('phone', $request->phone)->first();
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('Api Token of '. $user->name)->plainTextToken
            ], "Logged In Successfully.");
        } else {
            return $this->error("", "ဖုန်းနံပါတ်(သို့)လျို့ဝှက်နံပါတ် မှားယွင်းနေပါသည်။", 401);
        }
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete(); 
        return $this->success([
            'message' => 'Logged out successfully.'
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return $this->success($user);
    }
}
