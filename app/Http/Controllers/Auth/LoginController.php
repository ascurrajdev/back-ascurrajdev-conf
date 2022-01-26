<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller{

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="Documentacion de la api de ascurrajdev-conf"
     * )
     */

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Login",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 title="Esquema para realizar la peticion",
     *                  @OA\Property(
     *                      property="email",
     *                      description="email",
     *                      default="test@example.com",
     *                      format="string",
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      description="password",
     *                      default="12345678",
     *                      format="string"
     *                  ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="NOT CONTENT"
     *     ),
     *      @OA\Response( response="419", description="Error csrf token not found")
     * )
    */
    public function login(){
        request()->validate([
            "email" => ["required","email"],
            "password" => ["required"]
        ]);
       if(auth()->attempt(request()->only(["email","password"]))){
            request()->session()->regenerate();
            return response()->noContent();
       }
       throw ValidationException::withMessages([
           "email" => [trans("auth.failed")]
       ]);
    }
}