<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request; 
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    /**
     * Logs in an already created user
     * 
     * @param App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request) { 

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) { 
            $user = Auth::user(); 
            return response()->json([
                'access_token' => $user->createToken('BA')->accessToken,
            ], 200); 
        } else { 
            return response()->json([
                'error' => 'User not found'
            ], 401); 
        } 

    }

    /**
     * Creates a new user
     * 
     * @param App\Http\Requests\CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(CreateUserRequest $request) { 
        
        $user = User::create($request->all()); 
        return response()->json([
            'access_token' => $user->createToken('BA')->accessToken,
        ], 201);  

    }

    /**
     * Creates a new admin user
     * 
     * @param App\Http\Requests\CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function registerAdmin(CreateUserRequest $request) { 
        
        $user = User::create($request->all()); 
        $user->role = 'admin';
        $user->save();

        return response()->json([
            'access_token' => $user->createToken('BA')->accessToken,
        ], 201);  

    }
}