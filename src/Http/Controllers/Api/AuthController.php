<?php

namespace Zainburfat\rbac\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

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

    public function updateToken(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return ['token' => $token];
    }

    public function refreshToken()
    {
        $response = Http::asForm()->post('http://passport-app.test/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => 'the-refresh-token',
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'scope' => '',
        ]);

        return $response->json();
    }
}
