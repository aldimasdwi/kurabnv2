<?php

namespace App\Http\Controllers;

use App\Models\kurban;
use Illuminate\Http\Request;
use App\Http\Controllers\CloudinaryStorage;

class KurbanController extends Controller
{
    public function storkurban (Request $request)
    {

        $image  = $request->file('image');
        $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName()); 
         
        kurban::create([
            'type_kurban' => $request-> type_kurban,
            'harga' => $request-> harga,
            'berat' => $request->berat,
            'image' => $result
        ]);

          return redirect('/admin1');
    }

    public function hapus ($id)
    {
        $user = kurban::find($id);
        $user->delete();
        return redirect('/admin1');
    }

    public function update($id){

        $data = kurban::find($id);
        return view ('admin1.update', compact('data'));

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

        $kurban->update([
            'type_kurban' => $request->type_kurban,
            'harga' => $request->harga,
            'berat' => $request->berat,
            'image' => $image
        ]);

        return redirect('/admin1');
    }





}
