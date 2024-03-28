<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    //Register functionality
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $roleId = 2;

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $roleId
        ]);
        $user->save();

        return response()->json(['message' => 'User Registered Successfully'], 201);
    }

    //Login functionality
    /**
     * Login user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid Credentials'], 422);
        }
        $user = auth()->user();
        $role = $user->role_id;
        $message = '';
    
        switch ($role) {
            case 1:
                $message = 'Admin is logged in';
                break;
            case 2:
                $message = 'User is logged in';
                break;

            default:
                $message = 'Unknown role';
                break;
        }

        return response()->json(['message' => $message], 200);
    }

}