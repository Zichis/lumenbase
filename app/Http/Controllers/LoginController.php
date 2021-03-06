<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * @author Ezichi
 */
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate(
            $request, [
            'email' => 'required|email',
            'password' => 'required'
            ]
        );

        $remember = filter_var($request->input('remember'), FILTER_VALIDATE_BOOLEAN);
        $ttl = 60;

        if ($remember) {
            $ttl = 7200;
        }

        $input = $request->only('email', 'password');

        if (!$authorized = auth()->setTTL($ttl)->attempt($input)) {
            $code = 401;
            $output = [
                'code' => $code,
                'message' => 'Wrong login credentials!'
            ];

            return response()->json($output, $code);
        }

        $token = $this->respondWithToken($authorized);
        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'User logged in successfully.',
            'token' => $token
        ];

        return response()->json($output, $code);
    }
}
