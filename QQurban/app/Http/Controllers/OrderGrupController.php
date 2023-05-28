<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kurban;
use App\Models\order_grup;

class OrderGrupController extends Controller
{
    

    public function store(Request $request)
    {
        $data = order_grup::create([
            'id_user' => $request->id_user,
            'id_kurban' => $request->id_kurban,
            'nama_masjid' => $request->nama_masjid,
            'nama' => $request->nama,
            'total_harga' => $request->total_harga,
        ]);

        return response()
            ->json(['data' => $data, 'message' => 'berhasil order grup']);
    }


    public function status(Request $request, $id)
    {
        order_grup::find($id)->update([
            'status' => $request->status
        ]);
        return response()
            ->json(['message' => 'status berhasil di ubah']);
    }

    public function hapus($id)
    {
        order_grup::destroy($id);
        return response()
            ->json(['message' => 'berhasil di hapus']);
    }

  
    public function edit(Request $request, $id)
    {
        $data = order_grup::findOrFail($id);
        // $kurban = kurban::where('type_kurban', $request->input('type_kurban'))->first();

        // $data->kurban()->associate($kurban);
        $data->nama_masjid = $request->input('nama_masjid');
        $data->nama = $request->input('nama');
        $data->total_harga = $request->input('total_harga');
        // $data->user()->update(['no_hp' => $request->input('no_hp')]);
        $data->save();

        return response()
            ->json(['message' => 'berhasil di update']);
    }

    public function patungan (Request $request, $id)
    {
        $orderGrup = order_grup::find($id);

        $nama = $request->nama1 . ' ' . $request->nama2;
        $a = $request->total_harga1;
        $b = $request->total_harga2;
        $c = $a + $b;

        $orderGrup->nama = $nama;
        $orderGrup->total_harga = $c;
        $orderGrup->save();

        return response()
            ->json(['message' => 'kamu berhasil patungan']);
    }

    public function tampilkan ()
    {
        $data = order_grup::all();

        return response()
            ->json(['data' => $data, 'message' => 'data order grup']);
    }
}
