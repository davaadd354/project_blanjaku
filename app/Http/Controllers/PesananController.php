<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function proses_pesanan(Request $request){
        if($request->cart == null){
            return redirect('keranjang');
        }else{
            $cart = $request->cart;
            $keranjang = DB::table('cart as c')->leftJoin('produk as p','c.produk_id','p.id_produk')
                                               ->whereIn('c.id_cart',$cart)
                                               ->get();
            dd($keranjang);
        }

        return view('keranjang.proses_pesanan');
       
    }
}
