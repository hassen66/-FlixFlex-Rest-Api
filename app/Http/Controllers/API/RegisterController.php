<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Validator;

class RegisterController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 422,
                'status' => 'error',
                'errors' => $validator->messages()
            ],422);
        } else {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken(env('APP_NAME'))->plainTextToken;

            event(new Registered($user));

            return response()->json([
                'statusCode' => 200,
                'status' => 'sucess',
                'token' => $token,
                'user' => $user,
                'message' => 'Register Sucessful',
            ],200);
        }
    }

    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ],200);
    }
}
