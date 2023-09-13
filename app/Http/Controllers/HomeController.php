<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  Illuminate\Support\Facades\File;
use  Illuminate\Support\Facades\Auth;
use Image;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // initialize api. first argument will be your api key, and the second one is your package
    //     Rajaongkir::init('44a97a674b7ec3d2d3059bad6bcd4d9c', 'starter');

    //     $provinces = Province::all();
    //    $data = $provinces['results'][9]['province'];
       $home_slider = DB::table('home_slider')->where('status',1)->get();
        $kategori = DB::table('kategori_produk')->get();
        return view('home',compact('home_slider','kategori'));
    }

    public function tes_pertama(){
        return view('tes_dulu');
    }

    public function akun_saya(){
        $user_id = Auth::user()->id;
        $user_data = DB::table('users as u')->leftJoin('user_detail as ud','u.id','ud.user_id')
                                       ->where('u.id',$user_id)
                                       ->first();
        //dd($user_data);
        return view('user.akun_saya',compact('user_data'));
    }

    public function profil(){
        return view('user.profil');
    }

    public function edit_profil(Request $request){
    
        $nama_depan = $request->nama_depan;
        $nama_belakang = $request->nama_belakang;
        $nomor_telepon = $request->telp;
        $jenis_kelamin = $request->kelamin;
        $tgl_lahir = $request->date;
        $gambar = $request->file('gambar');
        $nama_gambar = null;
        $user_detail = DB::table('user_detail')->where('user_id',Auth::user()->id)->first();

        if($gambar != null){
            $nama_gambar = rand().'_'.$gambar->getClientOriginalName();
            $save_gbr = \Image::make($gambar);
            $save_gbr->resize(500,500)->save(public_path('gambar_profil/'.$nama_gambar));
        }else{

        }
        
        if($user_detail == null){
            DB::table('user_detail')->insert([
                'user_id' => Auth::user()->id,
                'nama_depan' => $nama_depan,
                'nama_belakang' => $nama_belakang,
                'nomor_telepon' => $nomor_telepon,
                'jenis_kelamin' => $jenis_kelamin,
                'tanggal_lahir' => $tgl_lahir,
                'foto_profil' => $nama_gambar
            ]);
        }else{
            if($gambar != null){
                File::delete('gambar_profil/'.$user_detail->foto_profil);
                DB::table('user_detail')->update([
                 'nama_depan' => $nama_depan,
                 'nama_belakang' => $nama_belakang,
                 'nomor_telepon' => $nomor_telepon,
                 'jenis_kelamin' => $jenis_kelamin,
                 'tanggal_lahir' => $tgl_lahir,
                 'foto_profil' => $nama_gambar
                ]);
            }else{
                DB::table('user_detail')->update([
                    'nama_depan' => $nama_depan,
                    'nama_belakang' => $nama_belakang,
                    'nomor_telepon' => $nomor_telepon,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tanggal_lahir' => $tgl_lahir
                   ]);
                  
            }
          

        }
        return redirect('akun_saya');
    }

    public function data_tampil_profil(Request $request){
        $user_id = Auth::user()->id;
        $user_data = DB::table('users as u')->leftJoin('user_detail as ud','u.id','ud.user_id')
                                       ->where('u.id',$user_id)
                                       ->first();
        //dd($user_data);
        return view('user.data_tampil_profil',compact('user_data'));
    }

    public function data_tampil_alamat(Request $request){
        $daftar_alamat = DB::table('alamat_user as au')->leftJoin('blw_prov as prov','au.id_provinsi','prov.id')
                                                       ->leftJoin('blw_kab as kab','au.id_kabupaten','kab.id')
                                                       ->leftJoin('blw_kec as kec','au.id_kecamatan','kec.id')
                                                       ->where('user_id',Auth::user()->id)
                                                       ->select(
                                                           'au.*',
                                                           'prov.nama as nama_prov',
                                                           'kab.nama as nama_kab',
                                                           'kec.nama as nama_kec' 
                                                       )
                                                       ->get();
        //return response()->json($daftar_alamat);
        return view('user.data_tampil_alamat',compact('daftar_alamat'));
    }

    public function tambah_alamat_user(Request $request){
        $provinsi = DB::table('blw_prov')->get();
        return view('user.tambah_alamat_user',compact('provinsi'));
    }

    public function data_tampil_kabupaten(Request $request){
        $id_prov = $request->id_provinsi;
        $kabupaten = DB::table('blw_kab')->where('idprov',$id_prov)->get();
        return response()->json($kabupaten);
    }
    
    public function data_tampil_kecamatan(Request $request){
        $id_kab = $request->id_kabupaten;
        $kecamatan = DB::table('blw_kec')->where('idKab',$id_kab)->get();
        return response()->json($kecamatan);
    }

    public function save_tambah_alamat(Request $request){
        $keterangan= $request->keterangan;
        $nama_penerima= $request->nama_penerima;
        $no_hp= $request->no_hp;
        $provinsi= $request->provinsi;
        $kabupaten= $request->kabupaten;
        $kecamatan= $request->kecamatan;
        $kode_pos= $request->kode_pos;
        $alamat= $request->alamat;

        DB::table('alamat_user')->insert([
            'user_id' => Auth::user()->id,
            'nama_penerima' => $nama_penerima,
            'no_hp' => $no_hp,
            'id_provinsi' => $provinsi,
            'id_kabupaten' => $kabupaten,
            'id_kecamatan' => $kecamatan,
            'kode_pos' => $kode_pos,
            'alamat_lengkap' => $alamat,
            'status' => 0,
            'keterangan' =>$keterangan
        ]);

       // return response()->json('sukses cuyy');
       $daftar_alamat = DB::table('alamat_user as au')->leftJoin('blw_prov as prov','au.id_provinsi','prov.id')
                                                    ->leftJoin('blw_kab as kab','au.id_kabupaten','kab.id')
                                                    ->leftJoin('blw_kec as kec','au.id_kecamatan','kec.id')
                                                    ->where('user_id',Auth::user()->id)
                                                    ->select(
                                                        'au.*',
                                                        'prov.nama as nama_prov',
                                                        'kab.nama as nama_kab',
                                                        'kec.nama as nama_kec' 
                                                    )
                                                    ->get();

        return view('user.data_tampil_alamat',compact('daftar_alamat'));
    }

    public function testing(){

        $pesanan = DB::table('pesanan')->where('id',5)->first();
        $bayar = DB::table('blw_pembayaran')->where('id',$pesanan->idbayar)->first();
        $alamat = DB::table('alamat_user as a')->leftJoin('blw_prov as pr','a.id_provinsi','pr.id')
                                                    ->leftJoin('blw_kab as kb','a.id_kabupaten','kb.id')
                                                    ->leftJoin('blw_kec as kc','a.id_kecamatan','kc.id')
                                                    ->where('id_alamat',$pesanan->alamat_id)
                                                    ->select(
                                                        'a.*',
                                                        'pr.nama as provinsi',
                                                        'kb.nama as kabupaten',
                                                        'kc.nama as kecamatan'
                                                    )
                                                    ->first();
                                                
        $keranjang = DB::table('cart as c')->leftJoin('produk as p','c.produk_id','p.id_produk')
                                               ->leftJoin('varian as v','c.varian_id','v.id_varian')
                                               ->leftJoin('sub_varian as sv','c.sub_varian_id','sv.id_sub_varian')
                                               ->leftJoin('gambar_produk as g', 'c.produk_id','g.produk_id')
                                               ->select(
                                                   'c.*',
                                                   'p.nama_produk',
                                                   'p.label_varian',
                                                   'p.label_sub_varian',
                                                   'p.stok',
                                                   'v.nama_varian',
                                                   'sv.nama_sub_varian',
                                                   'g.nama_gambar',
                                                   DB::raw('c.harga_produk * c.jumlah as harga_total')
                                               )
                                          ->groupBy('c.id_cart')
                                          ->where('c.id_transaksi',$pesanan->id)
                                          ->get();
                                          
        $data = [
            'pesanan' => $pesanan,
            'bayar' => $bayar,
            'alamat' => $alamat,
            'keranjang' => $keranjang
        ];
        return view('testing',$data);
    }

}