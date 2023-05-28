<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verifytoken;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class CobaController extends Controller
{


    protected function register(Request $request)
    {
        


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
            ]
        );



        $token = $user->createToken('auth_token')->plainTextToken;

        $validToken = rand(10, 100) . rand(10, 100);
        $get_token = new VerifyToken();
        $get_token->token = $validToken;
        $get_token->email = $user->email;
        $get_token->save();

        $get_user_email = $user->email;
        $get_user_name = $user->name;
        Mail::to($user->email)->send(new WelcomeMail($get_user_email, $validToken, $get_user_name));

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer', 'message' => 'otp berhasil di kirim']);
    }

    public function otp(Request $request)
    {
        $get_token = $request->token;
        $get_token = Verifytoken::where('token', $get_token)->first();

        if ($get_token) {
            $get_token->is_activated = 1;
            $get_token->save();
            $user = User::where('email', $get_token->email)->first();
            $user->is_activated = 1;
            $user->save();
            $getting_token = Verifytoken::where('token', $get_token->token)->first();
            $getting_token->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()
                ->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',]);
        } else {
            return response()->json('otp salah');
        }
    }

    public function login(Request $request)
    {
        $userr = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if (Auth::attempt($userr)) {
            $user = Auth::user();
            if ($user && $user->role === 'user') {

                $user = Auth::user();
                $user = User::where('email', $request['email'])->firstOrFail();

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()
                    ->json(['message' => 'welcome to home user', 'access_token' => $token, 'token_type' => 'Bearer',]);
           
                } elseif ($user && $user->role === 'admin') {

                $user = Auth::user();
                $user = User::where('email', $request['email'])->firstOrFail();

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()
                    ->json(['message' => 'welcome to home admin', 'access_token' => $token, 'token_type' => 'Bearer',]);
            }

        }
        return response()->json(['message'=> 'login gagal']);
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }


    public function profil(Request $request)
    {
        $user = $request->user()->name;

        return response()->json(["message" => 'hayy ' . $user]);
    }

    public function user ()
    {
        $data = User::all();

        return response()->json([$data]);
    }
}
