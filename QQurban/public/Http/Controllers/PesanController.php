<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesan;

class PesanController extends Controller
{
    public function pesan(Request $request)
    {
        pesan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'pesan' => $request->pesan,
        ]);

        return back();
    }

    
}
