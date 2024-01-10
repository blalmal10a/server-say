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
            } else {
                $response = ["message" => "Incorrect credentials"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
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
        if (!request()?->user() && !request()?->user()?->currentAccessToken())
            $token = $user->createToken('TOKEN_NAME_FOR_USER');
        else $token = request()->user()->currentAccessToken();
        return [
            'user' => $user,
            'token' => $token?->plainTextToken,
        ];
    }
}
