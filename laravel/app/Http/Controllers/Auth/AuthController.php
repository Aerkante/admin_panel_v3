<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'forgot', 'loginPanel', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::with('userData')->find(auth()->user()->id);


        return $this->createNewToken($token);
    }

    public function loginPanel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }



    public function forgot(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!$user) return response()->json(['message' => 'Usuário não encontrado.'], 404);

        $hash = md5(time());
        $newPass = substr(hexdec(substr($hash, rand(0, 26), 6)), 0, 6);
        $user->password = Hash::make($newPass);

        $user->save();

        $data = array(
            "to" => $user->email,
            "name" => $user->name,
            "pass" => $newPass
        );

        // return view('mail.reset-pass', compact('data'));

        Mail::send(new ResetPasswordMail($data));
        return response()->json(['success' => 'New password has ben sended'], 200);
    }


    public function deleteAccount()
    {
        try {
            $user = Auth::getUser();
            if (!$user) return response()->json(['message' => 'Usuário não encontrado.'], 404);

            $user->name = 'Usuário deletado';
            $user->email = Hash::make($user->email);
            $user->status = 404;
            $user->save();

            $this->logout();

            return ApiResponse::returnSuccess();
        } catch (\Throwable $th) {
            return ApiResponse::returnError($th->getMessage());
        }
    }


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout($message = "User successfully signed out")
    {
        auth()->logout();
        return response()->json(['message' => $message]);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $data = auth()->user();
        $user = User::find(auth()->user()->id);
        $data['tenant'] = TenantService::getTenantByUserId($user->id)->id ?? null;
        $data['roles'] = $user->roles->pluck('slug');
        return response()->json($data);
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $user = User::with('userData')->find(auth()->user()->id);
        $user['tenant'] = TenantService::getTenantByUserId($user->id)->id ?? null;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }
}
