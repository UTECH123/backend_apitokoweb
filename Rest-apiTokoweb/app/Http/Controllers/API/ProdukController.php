<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

use Illuminate\Http\Resource\ProdukResource

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produks = Produk::all();
        return response('produks'=> ProdukResource::collection
        ($produks,'message'=>'data berhasil ditampilkan',200));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::($data,[
            'nama' => 'required|max:255',
            'alamat'=> 'required|max:255',
            'harga'=> 'required',
        ]);

        if ($validator->fails()){
            return response(['error'=>$validator->errors(),'validatasi nama harga salah!']);
        }
        $produk = Produk::create($data);
        return response(['produk'=> new ProdukResource($produk),'message'=>'data berhasil ditambahkan']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        return response(['produk'=> new ProdukResource($produk),'message'=>'data berhasil diambil'],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        $produk->update($request->all());
        return response(['produk'=> new ProdukResource($produk),
        'message'=>'data berhasil diupdate'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();

        return response(['message'=>'data terhapus']);
    }
}
