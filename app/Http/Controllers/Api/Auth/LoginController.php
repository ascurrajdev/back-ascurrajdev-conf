<?php
namespace App\Http\Controllers\Api\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller{
    public function login(){
        request()->validate([
            "email" => ["required","email","exists:users"],
            "password" => ["required"],
            "platform" => ["required"],
        ]);
        $user = User::where('email',request("email"))->first();
        if(!$user || !Hash::check(request('password'), $user->password)){
            throw ValidationException::withMessages([
                "email" => __('auth.failed')
            ]);
        }
        $token = $user->createToken(request("platform"))->accessToken;
        return response()->json([
            "data" => [
                "token" => $token,
                "type" => "Bearer"
            ]
        ]);
    }
}