<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function kategori_produk($nama,$id){
        
        $produk_kategori = DB::table('produk as p')->where('p.kategori_id',$id)->get();

        return view('produk.kategori_produk',compact('produk_kategori'));
    }
}
