<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\kurban;
use App\Models\order;
use App\Models\pesan;
use App\Models\order_grup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WebController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function home(Request $request)
    {
        $all = order_grup::all();
        $data = kurban::all();
        $userr = $request->user();
        $user = order::where('id_user', $userr->id)->get();
        
        
        return view('user.home', compact('data', 'user', 'all'));
    }

    public function admin1()
    {
        $pesan = pesan::all();
        $ad = order_grup::all();
        $da = order::all();
        $data = kurban::all();
        return view('admin1.admin1', compact('data','da','ad','pesan'));
    }

    public function admin2()
    {
        return view('admin2.admin2');
    }

    public function tambah()
    {
        return view('admin1.store');
    }

    public function don($id)
    {
        $don = order_grup::find($id);
        return view('user.donasi', compact('don'));
    }

    public function order($id)
    {
        $data = kurban::find($id);
        return view('user.order', compact('data'));
    }

    public function storregister(Request $request)
    {
        $validatedData = $request->validate([
            'nama_masjid' => 'required|max:255',
            'no_hp' => 'required|max:255',
            'nama_user' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);

        return redirect('/login');

    }

    public function storlogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user && $user->role === 'user') {
                return redirect('/home');
            } elseif ($user && $user->role === 'admin1') {
                
                return redirect('/admin1');
            } elseif ($user && $user->role === 'admin2') {
                return redirect('/admin2');
            }
        }

        return back();
    }


}
