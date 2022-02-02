<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
class LogoutController extends Controller{
    public function logout(){
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return response()->noContent();
    }
}