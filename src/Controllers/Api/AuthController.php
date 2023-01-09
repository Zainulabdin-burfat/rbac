<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Zainburfat\Rbac\Models\Permission;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = auth()->user();
            
            $permissions = ['-'];
            if ($user->permissions) {
                foreach ($user->permissions as $permission) {
                    $permissions = $permission->name;
                }                
            }
            $token = $user->createToken($user->name,[$permissions]);

            $data = [
                'user' => $user,
                'token' => $token
            ];
            
            return response()->json(['data' => $data, 'status' => true]);

        } else {
            return response()->json(['message' => 'Invalid Email/password', 'status' => false]);
        }
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if (!$user) {
            return response()->json(['message' => 'User not created', 'status' => false]);
        }

        return response()->json(['message' => 'User created successfully..!', 'status' => true]);

    }    
}
