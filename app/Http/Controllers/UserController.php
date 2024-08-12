<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function UserRegistration(Request $request){
        // return "ok";
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => Hash::make($request->input('password')),  // Hash the password
            ]);

            return response()->json([
                'status'=>'success',
                'message' => 'User Registration Successful',

            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status'=>'failed',
                'message' => $e->getMessage(),

            ],200);
        }
    }
    function userLogin(Request $request) {
        // Retrieve the user by email
        $user = User::where('email', $request->input('email'))->first();

        // Check if the user exists and the password matches
        if ($user && Hash::check($request->input('password'), $user->password)) {
            // Create a token for the user
            $token = JWTToken::CreateToken($user->email);

            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful',
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized',
            ], 401); 
        }
    }

}
