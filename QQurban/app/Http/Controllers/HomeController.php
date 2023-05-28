<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verifytoken;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $get_user = User::where('email', Auth()->user()->email)->first();
        if ($get_user->is_activated == 1) {
            return response()->json('berhasil');
        } else {
            return response()->json('gagal');
        }
    }

    protected function register ( Request $request )
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);



        $validToken = rand(10, 100. . '2022');
        $get_token = new Verifytoken();
        $get_token->token = $validToken;
        $get_token->email = $request['email'];
        $get_token->save();
        $get_user_email = $request['email'];
        $get_user_name = $request['name'];
        Mail::to($request['email'])->send(new WelcomeMail($get_user_email, $validToken, $get_user_name));

        return response()->json(['data' => $user, 'message' => 'otp berhasil']);

    }

    

    
    public function otp (Request $request)
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
            return response()->json('otp berhasil');
        } else {
            return response()->json('otp salah');
        }
    }
}
