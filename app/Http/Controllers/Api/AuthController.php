<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('phone', 'password');

        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                $data = $this->makeUserData($user);
                return response()->json($data, 200);
                // $token = $user->createToken('api-token')->accessToken;
                // $response = ['token' => $token];
                // return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
        // if (Auth::attempt($credentials)) {
        //     $user = Auth::user();
        //     $data = $this->makeUserData($user);
        //     return response()->json($data, 200);
        // }

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

        if (!request()->user() && !request()->user()->currentAccessToken())
            $token = $user->createToken('TOKEN_NAME_FOR_USER');
        else $token = request()->user()->currentAccessToken();
        return [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'token' => $token?->plainTextToken,
        ];
    }
}
