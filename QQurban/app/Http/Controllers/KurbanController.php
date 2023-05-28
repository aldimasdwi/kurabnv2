<?php

namespace App\Http\Controllers;

use App\Models\kurban;
use App\Models\order_grup;
use Illuminate\Http\Request;
use App\Http\Controllers\CloudinaryStorage;

class KurbanController extends Controller
{
    public function storkurban(Request $request)
    {
        $image = $request->file('image');
        $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

        $data = kurban::create([
            'type_kurban' => $request->type_kurban,
            'harga' => $request->harga,
            'berat' => $request->berat,
            'image' => $result
        ]);

        return response()->json(['data' => $data, 'message' => 'Berhasil ditambah']);
    }

    public function hapus($id)
{
    $kurban = kurban::find($id);

    if ($kurban) {
        $gambar = $kurban->image;
        CloudinaryStorage::delete($gambar);
        $kurban->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    } else {
        return response()->json(['message' => 'Entitas tidak ditemukan']);
    }
}

    public function edit(Request $request, $id)
    {
        $kurban = Kurban::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $result = CloudinaryStorage::replace($kurban->image, $file->getRealPath(), $file->getClientOriginalName());
            $image = $result;
        } else {
            $image = $kurban->image;
        }

        $data = $kurban->update([
            'type_kurban' => $request->type_kurban,
            'harga' => $request->harga,
            'berat' => $request->berat,
            'image' => $image
        ]);

        return response()
            ->json(['data' => $data,'message' => 'berhasil di update']);
   
    }

    public function tampilkan ()
    {
        $data = kurban::all();

        return response()
            ->json(['data' => $data]);
   
    }
}
