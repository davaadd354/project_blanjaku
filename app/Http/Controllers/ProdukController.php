<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function kategori_produk($nama,$id){
        
        $produk_kategori = DB::table('produk as p')->where('p.kategori_id',$id)->get();
        $id_kategori = $id;
        return view('produk.kategori_produk',compact('produk_kategori','id_kategori'));
    }

    public function filter_produk_kategori(Request $request){
        $harga_min = $request->harga_min;
        $harga_max = $request->harga_max;
        $id_kategori = $request->id_kategori;

        $produk_kategori = DB::table('produk as p')->where('p.kategori_id',$id_kategori);
        if(!empty($harga_min)){
            $produk_kategori = $produk_kategori->where('harga_coret','>=',$harga_min);
        }
        if(!empty($harga_max)){
            $produk_kategori = $produk_kategori->where('harga_coret','<=',$harga_max);
        }
        $produk_kategori = $produk_kategori->get();
        
        return view('produk.filter_produk_kategori',compact('produk_kategori'));
    }

    public function daftar_produk($keyword = ''){
        if($keyword == ''){
            $produk = DB::table('produk')->get();
        }else{
            $produk = DB::table('produk')->where('nama_produk','like','%'.$keyword.'%')->get();
        }
        $kategori = DB::table('kategori_produk')->get();
        return view('produk.daftar_produk',compact('produk','keyword','kategori'));
    }

    public function filter_produk(Request $request){
        $harga_min = $request->harga_min;
        $harga_max = $request->harga_max;
        $id_kategori = $request->id_kategori;

        $produk = DB::table('produk');
        if(!empty($harga_min)){
            $produk = $produk->where('harga_coret','>=',$harga_min);
        }
        if(!empty($harga_max)){
            $produk = $produk->where('harga_coret','<=',$harga_max);
        }
        if(!empty($id_kategori)){
            $produk = $produk->where('kategori_id',$id_kategori);
        }
        $produk = $produk->get();

        return view('produk.filter_produk',compact('produk'));
    }

    public function detail_produk($id){
        $produk = DB::table('produk as p')->where('p.id_produk',$id)->first();
        $produk_varian = DB::table('produk_varian as pv')->where('pv.produk_id',$id)
                                                         ->where('sub_varian_id','>',0)
                                                         ->leftJoin('varian as v','pv.varian_id','v.id_varian')
                                                         ->leftJoin('sub_varian as sv','pv.sub_varian_id','sv.id_sub_varian')
                                                         ->get();
        $gambar = DB::table('gambar_produk')->where('produk_id',$id)->get();
        $varian = DB::table('varian')->where('produk_id',$id)->get();
        $sub_varian = DB::table('sub_varian')->where('produk_id',$id)->get();


        $data = [
            'produk' => $produk,
            'produk_varian' => $produk_varian,
            'gambar' => $gambar,
            'varian' => $varian,
            'sub_varian' => $sub_varian
        ];



        return view('produk.detail_produk',$data);
    }

    public function tampil_gambar_utama(Request $request){
        $gambar = DB::table('gambar_produk')->where('id_gambar',$request->id_gambar)->first();
        return view('produk.tampil_gambar_utama',compact('gambar'));
    }

    public function cek_sub_varian(Request $request){
        $id_produk = $request->produk_id;
        $id_varian = $request->varian_id;
        $produk = DB::table('produk')->where('id_produk',$id_produk)->first();
        $produk_varian = DB::table('produk_varian as pv')->leftJoin('varian as v','pv.varian_id','v.id_varian')
                                                         ->leftJoin('sub_varian as sv','pv.sub_varian_id','sv.id_sub_varian')
                                                         ->where('pv.produk_id',$id_produk)
                                                         ->where('pv.varian_id',$id_varian)
                                                         ->get();
        return view('produk.tampil_sub_varian',compact('produk_varian','produk'));
    }
}
