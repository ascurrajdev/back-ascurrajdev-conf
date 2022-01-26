<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller{
    public function register(){
        request()->validate([
            "name" => ["required","string"],
            "email" => ["required","email","unique:users"],
            "password" => ["string","min:8","confirmed"]
        ]);
        $user = User::create([
            "name" => request("name"),
            "email" => request("email"),
            "password" => Hash::make(request("password"))
        ]);
        auth()->login($user);
        return response()->noContent();
    }
}