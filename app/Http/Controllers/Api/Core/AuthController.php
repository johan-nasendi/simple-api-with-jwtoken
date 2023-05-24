<?php

namespace App\Http\Controllers\Api\Core;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AuthUserResource;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function getAllUser()
    {
        $data = User::all();
        return response()->json([
            'error' => false,
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $data
        ], 200);
    }

    public function postRegister(Request $request){
        $validation = Validator::make($request->only(
            'name',
            'email',
            'password',
            'password_confirmation',
            ), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'error' => true,
                'status' => false,
                'message' => $validation->errors()->first(),
                'data' => $validation->errors()
            ],400);
        } else {
            try {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ];
                $user = User::create($data);
                $token = JWTAuth::attempt([
                    'email' => $request->email,
                    'password' => $request->password
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Selamat datang! Anda telah berhasil Register!',
                    'token' => $token,
                    'data' => JWTAuth::user()
                ]);
            } catch (\Throwable $th) {
                $user = User::where('email', $request->email)->first();
                if ($user != null) {
                    $user->delete();
                }
                return ResponseFormatter::responseError($th->getMessage(), 400);
            }
        }
    }

    public function postLogin(Request $request){

        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(
            [
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()
            ],400);
        } else {
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid login credentials.'
                    ], 400);
                }
            } catch (\Throwable $th) {
                return $credentials;
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to generate tokens!',
                ], 500);
            }
            $user = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'Selamat datang! Anda telah berhasil Log in!',
                'token' => $token,
                'data' =>  AuthUserResource::make($user),
            ]);
        }

    }

    public function postLogout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => true,
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => $validator->errors()
                ],400);
        } else {
            try {
                JWTAuth::invalidate($request->token);
                return ResponseFormatter::responseSuccess('Logout successful!');
            } catch (JWTException $exception) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                ], 500);
            }
        }
    }
}
