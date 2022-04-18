<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function input_tambah_produk_keranjang(Request $request){
        $produk_id = $request->produk_id;
        $toko_id = $request->toko_id;
        $user_id = Auth::user()->id;
        $varian_id = $request->varian_id;
        $sub_varian_id = $request->sub_varian_id;
        $jumlah = $request->jumlah;
        $catatan = $request->catatan;

        $produk_varian = DB::table('produk_varian')->where('varian_id',$varian_id)
                                                   ->where('sub_varian_id',$sub_varian_id)
                                                   ->first();

        $produk = DB::table('produk')->where('id_produk',$produk_id)->first();
        
        if($produk_varian != null){
            if($produk_varian->harga_coret != null){
                $harga = $produk_varian->harga_coret;
            }else{
                $harga = $produk_varian->harga_normal;
            }
            
            $data=[
                'user_id' => $user_id,
                'toko_id' => $toko_id,
                'produk_id' => $produk_id,
                'produk_varian_id' => $produk_varian->id_produk_variasi, 
                'harga_produk' => $harga,
                'jumlah' => $jumlah,
                'catatan' => $catatan,
                'status' => 0,
                'varian_id' => $varian_id,
                'sub_varian_id' => $sub_varian_id
            ];

        }else{
            $harga = $produk->harga_coret;
            $data=[
                'user_id' => $user_id,
                'toko_id' => $toko_id,
                'produk_id' => $produk_id,
                'harga_produk' => $harga,
                'jumlah' => $jumlah,
                'catatan' => $catatan,
                'status' => 0
            ];
        }

        DB::table('cart')->insert($data);

        return redirect('keranjang_belanja');       
    }

    public function keranjang_belanja(){
        $user_id = Auth::user()->id;

        $keranjang = DB::table('cart as c')->leftJoin('produk as p','c.produk_id','p.id_produk')
                                           ->leftJoin('varian as v','c.varian_id','v.id_varian')
                                           ->leftJoin('sub_varian as sv','c.sub_varian_id','sv.id_sub_varian')
                                           ->select(
                                               'c.*',
                                               'p.nama_produk',
                                               'p.label_varian',
                                               'p.label_sub_varian',
                                               'p.stok',
                                               'v.nama_varian',
                                               'sv.nama_sub_varian',
                                               //DB::raw('sum(c.jumlah) as jumlah_pcs')
                                               DB::raw('c.harga_produk * c.jumlah as kontol')
                                           )
                                      ->groupBy('c.id_cart')
                                      ->where('c.user_id',$user_id)
                                      ->where('c.status',0)
                                      ->get();
        $total_harga = 0;
        foreach($keranjang as $k){
            $total_harga += $k->harga_produk * $k->jumlah;
        }
        //dd($keranjang);
        return view('keranjang.keranjang',compact('keranjang','total_harga'));
    }

    public function ubah_jumlah_produk_cart(Request $request){
        if($request->jumlah >= 1){
            DB::table('cart')->where('id_cart',$request->id_cart)->update(['jumlah' => $request->jumlah]);
            $data = DB::table('cart')->where('id_cart',$request->id_cart)->first();
            return response()->json($data);
        }
        
    }

    public function hapus_produk_cart(Request $request){
        $id = $request->id_cart;
        DB::table('cart')->where('id_cart',$id)->delete();

        $user_id = Auth::user()->id;
        $keranjang = DB::table('cart as c')->leftJoin('produk as p','c.produk_id','p.id_produk')
                                           ->leftJoin('varian as v','c.varian_id','v.id_varian')
                                           ->leftJoin('sub_varian as sv','c.sub_varian_id','sv.id_sub_varian')
                                           ->select(
                                               'c.*',
                                               'p.nama_produk',
                                               'p.label_varian',
                                               'p.label_sub_varian',
                                               'v.nama_varian',
                                               'sv.nama_sub_varian'
                                           )
                                           ->where('c.user_id',$user_id)
                                           ->where('c.status',0)
                                           ->get();
        dd($keranjang);
        $total_harga = 0;
        foreach($keranjang as $k){
            $total_harga += $k->harga_produk;
        }
        //return response()->json($keranjang);
        return view('keranjang.data_keranjang',compact('keranjang','total_harga'));
        
    }
}
