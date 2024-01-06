<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $data = $this->makeUserData($user);
            return response()->json($data, 200);
        }

        return response()->json(['errors' => ['auth' => 'Invalid login credentials']], 422);
    }

    public function getUser(Request $request)
    {
        $user = $request->user();
        $data = $this->makeUserData($user);
        return response()->json($data, 200);
    }

    private function makeUserData($user)
    {
        $roles = $user->getRoleNames();
        $permissions = $user->getPermissionNames();
        $token = $user->createToken('TOKEN_NAME_FOR_USER');

        return [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'token' => $token->plainTextToken,
        ];
    }
}
