<?php

namespace Zainburfat\rbac\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            $permissions = [];
            foreach ($user->roles as $role) {
                $permissions[] = $role->permissions->pluck('name')->toArray();
            }

            // Converts multi-dimention array into single array
            $permissions = call_user_func_array('array_merge', $permissions);

            $token = $user->createToken('My Token', array_unique($permissions))->accessToken;

            $data = [
                "name" => $user->name,
                "email" => $user->email,
                "accessToken" => $token
            ];

            return response()->json([
                'status' => 200,
                'success' => true,
                'data' => $data,
                'message' => 'logged in successfully',
            ], 200);
        }

        return false;
    }
}
