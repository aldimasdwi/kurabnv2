<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesan;

class PesanController extends Controller
{
    public function pesan(Request $request)
    {
    $data = pesan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'pesan' => $request->pesan,
        ]);

        return response()
            ->json(['data' => $data, 'message' => 'pesan berhasil di kirim']);
    
    }

    public function semuapesan ()
    {
        $data = pesan::all();

        return response()
            ->json(['data' => $data, 'message' => 'semua pesan']);

    }

    public function delete($id)
    {
        pesan::destroy($id);

        return response()
            ->json(['message' => 'pesan berhasil di hapus']);
    }

}
