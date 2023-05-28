<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kurban;
use App\Models\order_grup;

class OrderGrupController extends Controller
{
    public function ordergrup($id){
       $data = kurban::find($id);

        return view('user.ordergrup', compact('data'));
    }

    public function store(Request $request){
        order_grup::create([
            'id_user' => $request -> id_user,
            'id_kurban' => $request -> id_kurban,
            'nama_masjid' => $request -> nama_masjid,
            'nama' => $request -> nama,
            'total_harga' => $request -> total_harga,
        ]);

        return redirect('/home');

    }


    public function status(Request $request,$id)
    {
        order_grup::find($id)->update([
            'status' => $request -> status
        ]);
        return back();
    }

    public function hapus ($id)
    {
        order_grup::destroy($id);
        return back();
    }

    public function update($id)
    {
        $data = order_grup::find($id);

        return view('admin1.updateordergrup', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = order_grup::findOrFail($id);
        $kurban = kurban::where('type_kurban', $request->input('type_kurban'))->first();

        $data->kurban()->associate($kurban);
        $data->nama_masjid = $request->input('nama_masjid');
        $data->nama = $request->input('nama');
        $data->total_harga = $request->input('total_harga');
        $data->user()->update(['no_hp' => $request->input('no_hp')]);
        $data->save();

        return redirect('/admin1');
    }

    public function donasi(Request $request, $id)
    {
        $orderGrup = order_grup::find($id);

        $nama = $request->nama1 . ' ' . $request->nama2;
        $a = $request->total_harga1;
        $b = $request->total_harga2;
        $c = $a + $b;

        $orderGrup->nama = $nama;
        $orderGrup->total_harga = $c;
        $orderGrup->save();

        return redirect('/home');
    }

}
