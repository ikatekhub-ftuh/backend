<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Error;
use Exception;
use Google_Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

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
            'password'          => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password'  => 'min:6'
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        // Validasi email exist
        $user = User::where('email', $request->email)->first();
        if ( $user ) {
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
                "message" => 'Server error: '. $err,
            ], 500);
        }

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'success'   => true,
            'message'   => 'Register successful.',
            'token'     => $token,
        ], 201);
    }

    // Login dengan email dan password
    public function login(Request $request)
    {
        try {

            $v = Validator::make($request->all(), [
                'email'     => 'required|string|email',
                'password'  => 'required|min:6',
            ]);
    
            if ( $v->fails() ) {
                return response()->json([
                    'success' => false,
                    'message' => $v->errors(),
                ], 400);
            }
    
            $user = User::where('email', $request->email)->first();
    
            if ( $user->is_banned ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been banned.',
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
                'data'      => [
                    'email' => $user->email,
                ],
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
            $idToken = $request->idtoken;
    
            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            
            $payload = $client->verifyIdToken($idToken);
            
            if ($payload) {
                $googleId = $payload['sub'];
                $user = User::where('google_id', $googleId)->first();
    
                if (!$user) {
                    $user = User::create([
                        'name' => $payload['name'],
                        'email' => $payload['email'],
                        'google_id' => $googleId,
                    ]);
                }
    
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['token' => $token]);
            } else {
                return response()->json(['error' => $payload], 401);
            }
        } catch (Exception $err) {
            // \Log::error('Google login error: '.$err->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $err->getMessage()
            ], 500);            
        }
    }
    
    public function logout(Request $request) {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            
            return response()->json([
                'success'   => true,
                'message'   => 'Logout successful.',
                'user'      => $user,
            ], 200);
        } catch(Exception $err) {
            return response()->json([
                'success'   => false,
                'message'   => 'Error logout: '.$err,
            ], 500);
        } 
    }
}
