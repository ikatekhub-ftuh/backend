<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Google_Client;
use Google\Service\Oauth2;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    // Register dengan email dan password
    public function register(Request $request)
    {
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'email'             => 'required|string|email',
            'password'          => 'min:8|required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        // Validasi email exist
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                "success" => false,
                "message" => 'The email has already been taken.',
            ], 409);
        }

        try {
            // Create user
            $user = User::create([
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
            ]);
        } catch (Exception $err) {
            return response()->json([
                "success" => false,
                "message" => 'Server error: ' . $err->getMessage(),
            ], 500);
        }

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'success'   => true,
            'message'   => 'Register successful.',
            'data'     => $user,
            'token'     => $token,
        ], 201);
    }

    // Login dengan email dan password
    public function login(Request $request)
    {
        try {
            $v = Validator::make($request->all(), [
                'email'     => 'required|string|email|exists:users,email',
                'password'  => 'required|min:6',
            ]);

            if ($v->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => implode('\n', $v->errors()->all()),
                ], 400);
            }

            $user = User::where('email', $request->email)->first();

            if ($user->is_banned) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is banned.',
                    'reason' => $user->ban_reason,
                ], 403);
            }
    
            if ( !$user || ! Hash::check($request->password, $user->password) ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials. Please check your email and password.',
                ], 401);
            }

            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'success'   => true,
                'message'   => 'Login successful.',
                'data'      => $user,
                'token'     => $token,
            ], 201);
        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    // Login dengan Google
    public function handleGoogleLogin(Request $request)
    {
        try {
            $v = Validator::make($request->all(), [
                'access_token_client' => 'required',
            ]);            
            if ($v->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $v->errors(),
                ], 400);
            }

            $access_token_client = $request->access_token_client;

            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $client->setAccessToken($access_token_client);

            $oauth2     = new Oauth2($client);
            $userInfo   = $oauth2->userinfo->get();

            if ($userInfo) {
                $user = User::where('email', $userInfo->email)->first();

                if (!$user) {
                    $user = User::create([
                        'email'     => $userInfo->email,
                        'avatar'    => $userInfo->picture,
                    ]);
                }

                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'success'   => true,
                    'message'   => 'Auth successful.',
                    'data'      => $user,
                    'token'     => $token,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Bad request'
                ], 400);
            }
        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error'   => $err->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();

            return response()->json([
                'success'   => true,
                'message'   => 'Logout successful.',
                'data'      => $user,
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'success'   => false,
                'message'   => 'Error logout: ' . $err,
            ], 500);
        }
    }
}
