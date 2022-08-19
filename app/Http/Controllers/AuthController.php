<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function register(Request $request)
    {
        /* $validatedData = $request->validate([ */
        /*     'username' => 'string|max:255', */
        /*     'email' => 'required|string|email|max:255|unique:users', */
        /*     'password' > 'required|string|min:8' */
        /* ]); */

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where("email", $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'userId' => $user->id,
            'name' => $user->name,
            'token_type' => 'Bearer'
        ]);
    }

    public function show(Request $request)
    {
        $userId = $request->query("userId");
        $user = User::find($userId);
        return response()->json($user, 200);
    }
}
