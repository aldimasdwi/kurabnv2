<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\User;
use App\Models\kurban;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $data = order::create([
            'id_user' => $request->id_user,
            'id_kurban' => $request->id_kurban,
            'nama_masjid' => $request->nama_masjid,
            'nama' => $request->nama,
            'harga' => $request->harga
        ]);

        return response()
            ->json(['data' => $data, 'message' => 'berhasil di order']);
    }

    public function hapus($id)
    {
        order::destroy($id);
        return response()
            ->json(['message' => 'berhasil di hapus']);
    }

    public function status(Request $request, $id)
    {
        order::find($id)->update([
            'status' => $request->status
        ]);

        return response()
            ->json(['message' => 'status berhasil di ubah']);
    }

    

    public function edit(Request $request, $id)
    {
        $data = order::findOrFail($id);
        // $kurban = kurban::where('type_kurban', $request->input('type_kurban'))->first();

        // $data->kurban()->associate($kurban);
        $data->nama_masjid = $request->input('nama_masjid');
        $data->nama = $request->input('nama');
        $data->harga = $request->input('harga');
        // $data->user()->update(['no_hp' => $request->input('no_hp')]);
        $data->save();

        return response()
            ->json(['message' => 'berhasil di update']);
    }

    public function tampilanuser (Request $request)
    {
        $userr = $request->user();
        $user = order::where('id_user', $userr->id)->get();

        return response()
            ->json(['data' => $user, 'message' => 'tampilan orderindividu ' . $userr->name . ' .']);
    }

    public function tampilanadmin()
    {
        $data = order::all();

        return response()->json(['data' => $data]);
    }

}
