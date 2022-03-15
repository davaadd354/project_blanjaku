<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  DataTables;
use  Illuminate\Support\Facades\File;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function data_slider(){
        $data_slider = DB::table('home_slider')->get();

        return DataTables::of($data_slider)
            ->addColumn('action',function($data){
                $btn = '<button type="button" class="btn btn-danger text-white btn-sm" onclick="hapus_slider(' . $data->id_slider . ')" >
                HAPUS
                </button> <br>';
                $btn = $btn .'<button type="button" class="btn btn-primary text-white btn-sm" onclick="ubah_slider(' . $data->id_slider . ')" data-bs-toggle="modal" data-bs-target="#edit_slider" >
                UBAH
                </button> <br>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function home_slider(){
        return view('admin.slider.home_slider');
    }
    public function hapus_slider(Request $request){
        $slider_id = $request->id_slider;
        $hapus = DB::table('home_slider')->where('id_slider',$slider_id)->first();

        //Hapus file gambar
        File::delete('gambar_slider/'.$hapus->gambar);
        //Hapus Database Slider
        DB::table('home_slider')->where('id_slider',$slider_id)->delete();
    }
    public function tambah_slider(Request $request){
        $judul = $request->judul;
        $link_slider = $request->link_slider;
        $gambar = $request->file('gambar');
        $nama_gambar = rand().'.'.$gambar->getClientOriginalName();
        $gambar->move('gambar_slider',$nama_gambar);

        DB::table('home_slider')->insert([
            'judul' => $judul,
            'gambar' => $nama_gambar,
            'link' => $link_slider,
            'status' => 1
        ]);

        return redirect()->back();

    }
    public function ubah_slider(Request $request){
        $slider = DB::table('home_slider')->where('id_slider',$request->id_slider)->first();
        return view('admin.slider.tampil_edit_slider',compact('slider'));
    }
    public function edit_slider_save(Request $request){
        $id_slider = $request->id_slider;
        $judul = $request->judul;
        $link = $request->link;
        $status = $request->status;
        $slider = DB::table('home_slider')->where('id_slider',$request->id_slider)->first();
        $nama_gambar = $slider->gambar;

        $gambar = $request->file('gambar');
        if($gambar != null){
             //Hapus file gambar Lama
            File::delete('gambar_slider/'.$slider->gambar);
            $nama_gambar = rand().'.'.$gambar->getClientOriginalName();
            $gambar->move('gambar_slider',$nama_gambar);
        }
        
        $data = [
            'judul' => $judul,
            'gambar' => $nama_gambar,
            'link' => $link,
            'status' => $status
        ];

        DB::table('home_slider')->where('id_slider',$request->id_slider)->update($data);
        return redirect()->back();
    }

    public function kategori_produk(){
        return view('admin.produk.kategori_produk');
    }

    public function data_kategori(){
        $data_kategori = DB::table('kategori_produk')->get();

        return DataTables::of($data_kategori)
            ->addColumn('action',function($data){
                $btn = '<button type="button" class="btn btn-danger text-white btn-sm" onclick="hapus_kategori(' . $data->id_kategori . ')" >
                HAPUS
                </button> <br>';
                $btn = $btn .'<button type="button" class="btn btn-primary text-white btn-sm" onclick="ubah_kategori(' . $data->id_kategori . ')" data-bs-toggle="modal" data-bs-target="#edit_kategori" >
                UBAH</button> <br>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }

    public function tambah_kategori(Request $request){
        $nama = $request->nama;
        $gambar = $request->file('gambar_kategori');
        $nama_gambar = rand().'.'.$gambar->getClientOriginalName();
        $gambar->move('gambar_kategori',$nama_gambar);

        DB::table('kategori_produk')->insert([
            'nama_kategori' => $nama,
            'gambar' => $nama_gambar,
            'status' => 1
        ]);

        return redirect()->back();

    }

    public function hapus_kategori(Request $request){
        $kategori_id = $request->id_kategori;
        $hapus = DB::table('kategori_produk')->where('id_kategori',$kategori_id)->first();

        //Hapus file gambar
        File::delete('gambar_kategori/'.$hapus->gambar);
        //Hapus Database Slider
        DB::table('kategori_produk')->where('id_kategori',$kategori_id)->delete();
    }

    public function ubah_kategori(Request $request){
        $kategori = DB::table('kategori_produk')->where('id_kategori',$request->id_kategori)->first();
        return view('admin.produk.tampil_edit_kategori',compact('kategori'));
    }

    public function edit_kategori_save(Request $request){
        $id_kategori = $request->id_kategori;
        $judul = $request->nama;
        $status = $request->status;
        $kategori = DB::table('kategori_produk')->where('id_kategori',$id_kategori)->first();
        $nama_gambar = $kategori->gambar;

        $gambar = $request->file('gambar');
        if($gambar != null){
             //Hapus file gambar Lama
            File::delete('gambar_kategori/'.$kategori->gambar);
            $nama_gambar = rand().'.'.$gambar->getClientOriginalName();
            $gambar->move('gambar_kategori',$nama_gambar);
        }
        
        $data = [
            'nama_kategori' => $judul,
            'gambar' => $nama_gambar,
            'status' => $status
        ];

        DB::table('kategori_produk')->where('id_kategori',$request->id_kategori)->update($data);
        return redirect()->back();
    }

    public function daftar_produk(){
        return view('admin.produk.daftar_produk');
    }

    public function tambah_produk(){
       $kategori = DB::table('kategori_produk')->get();
        return view('admin.produk.tambah_produk',compact('kategori'));
    }

    public function save_tambah_produk(Request $request){

        $nama_produk = $request->nama;
        $kategori = $request->kategori;
        $stok = $request->stok;
        $min_order = $request->min_order;
        $harga_normal = $request->harga_normal;
        $harga_coret = $request->harga_coret;
        $berat = $request->berat;
        $deskripsi = $request->deskripsi;
        $gambar = $request->file('gambar');

        $data = [
            'user_id' => Auth::user()->id,
            'kategori_id' => $kategori,
            'nama_produk' => $nama_produk,
            'stok' => $stok,
            'min_order' => $min_order,
            'harga_normal' => $harga_normal,
            'harga_coret' => $harga_coret,
            'deskripsi' => $deskripsi,
            'berat' => $berat,
            'status_variasi_produk' => 0
        ];

        $input_produk = DB::table('produk')->insertGetId($data);

        foreach($gambar as $g){
            $nama_gambar = rand().'.'.$g->getClientOriginalName();
            $g->move('gambar_produk',$nama_gambar);
            DB::table('gambar_produk')->insert([
                'user_id' => Auth::user()->id,
                'produk_id' => $input_produk,
                'nama_gambar' => $nama_gambar
            ]);
        }

        return redirect()->back();
    }

    public function tampil_data_produk(){
        $data_produk = DB::table('produk')->get();

        return DataTables::of($data_produk)
            ->addColumn('action',function($data){
                $btn = '<button type="button" class="btn btn-danger text-white btn-sm" onclick="hapus_produk(' . $data->id_produk . ')" >
                HAPUS
                </button> <br>';
                $btn = $btn .'<a href="edit_data_produk/'. $data->id_produk .'" class="btn btn-primary text-white btn-sm">
                UBAH</a> <br>';
                return $btn;
            })
            ->addColumn('gambar',function($data){
                $gambar = DB::table('gambar_produk')->where('produk_id',$data->id_produk)->first();
                $gbr =  '<img width="100px" src=/gambar_produk/'.$gambar->nama_gambar.'>';
                return $gbr;
            })
            ->rawColumns(['action','gambar'])
            ->make(true);
    }

    public function edit_data_produk($id){

        $kategori = DB::table('kategori_produk')->get();
        $produk = DB::table('produk')->where('id_produk',$id)->first();
        $gambar = DB::table('gambar_produk')->where('produk_id',$id)->get();
        $produk_varian = DB::table('produk_varian')
                                                   ->leftJoin('varian','produk_varian.varian_id','varian.id_varian')
                                                   ->leftJoin('sub_varian','produk_varian.sub_varian_id','sub_varian.id_sub_varian') 
                                                   ->where('produk_varian.produk_id',$id)
                                                   ->get();
        $varian = DB::table('varian')->where('produk_id',$id)->get();
        $sub_varian = DB::table('sub_varian')->where('produk_id',$id)->get();

        $data = [
            'produk' => $produk,
            'kategori' => $kategori,
            'gambar' => $gambar,
            'produk_varian' =>$produk_varian,
            'varian' =>$varian,
            'sub_varian' =>$sub_varian
        ];
        return view('admin.produk.edit_data_produk',$data);
    }

    public function save_tambah_nama_varian(Request $request){
        $nama_varian = $request->nama_varian;
        $label_varian = $request->label_varian;
        $label_sub_varian = $request->label_sub_varian;
        $id_produk = $request->id_produk;

        // update data produk
        DB::table('produk')->where('id_produk',$id_produk)->update([
            //'status_variasi_produk' => 1,
            'label_varian' => $label_varian,
            'label_sub_varian' => $label_sub_varian
        ]);

        //Data Produk
        $produk = Db::table('produk')->where('id_produk',$id_produk)->first();


        //tambah id varian produk
        $varian = DB::table('varian')->insertGetId([
            'user_id' => Auth::user()->id,
            'produk_id' => $id_produk,
            'nama_varian' => $nama_varian
        ]);

       
        $sub_varian = DB::table('sub_varian')->where('produk_id',$request->id_produk)->get();

        if(count($sub_varian) != 0){
            foreach($sub_varian as $sv){
                DB::table('produk_varian')->insert([
                    'user_id' => Auth::user()->id,
                    'produk_id' => $id_produk,
                    'varian_id' => $varian,
                    'sub_varian_id' => $sv->id_sub_varian,
                    'harga_normal' => $produk->harga_normal,
                    'harga_coret' => $produk->harga_coret,
                    'stok' => 0
                ]);
            }
        }else{
            DB::table('produk_varian')->insert([
                'user_id' => Auth::user()->id,
                'produk_id' => $id_produk,
                'varian_id' => $varian,
                'sub_varian_id' => 0,
                'harga_normal' => $produk->harga_normal,
                'harga_coret' => $produk->harga_coret,
                'stok' => 0
            ]);
        }

        $varian_produk = DB::table('varian')->where('produk_id',$id_produk)->get();
        $produk_varian = DB::table('produk_varian')
                                ->leftJoin('varian','produk_varian.varian_id','varian.id_varian')
                                ->leftJoin('sub_varian','produk_varian.sub_varian_id','sub_varian.id_sub_varian') 
                                ->where('produk_varian.produk_id',$id_produk)
                                ->get();
        $data=[
            'produk' => $produk,
            'varian' => $varian_produk,
            'sub_varian' => $sub_varian,
            'produk_varian' => $produk_varian
        ];

        //return response()->json($data);
        return view('admin.produk.tampil_varian_produk',$data);
        
    }

    public function save_tambah_sub_varian(Request $request){
        $nama_sub_varian = $request->nama_sub_varian;
        $label_varian = $request->label_varian;
        $label_sub_varian = $request->label_sub_varian;
        $id_produk = $request->id_produk;

        // update data produk
        DB::table('produk')->where('id_produk',$id_produk)->update([
            'label_varian' => $label_varian,
            'label_sub_varian' => $label_sub_varian
        ]);

        //hapus produk tanpa sub_varian
        $produk_tanpa_sub_varian = DB::table('produk_varian')->where('produk_id',$id_produk)
                                                             ->where('sub_varian_id',0)
                                                             ->delete();

        //Tambah Sub Varian
        $sub_varian_id = DB::table('sub_varian')->insertGetId([
            'user_id' => Auth::user()->id,
            'produk_id' => $id_produk,
            'nama_sub_varian' => $nama_sub_varian
        ]);

        //Ambil semua data varian
        $varian = DB::table('varian')->where('produk_id',$id_produk)->get();

        //Ambil data produk
        $produk = DB::table('produk')->where('id_produk',$id_produk)->first();

        //Tambah Produk Varian
        foreach($varian as $va){
            DB::table('produk_varian')->insert([
                'user_id' => Auth::user()->id,
                'produk_id' => $id_produk,
                'varian_id' => $va->id_varian,
                'sub_varian_id' => $sub_varian_id,
                'harga_normal' => $produk->harga_normal,
                'harga_coret' => $produk->harga_coret,
                'stok' => 0
            ]);
        }

        $produk_varian = DB::table('produk_varian')
                                ->leftJoin('varian','produk_varian.varian_id','varian.id_varian')
                                ->leftJoin('sub_varian','produk_varian.sub_varian_id','sub_varian.id_sub_varian') 
                                ->where('produk_varian.produk_id',$id_produk)
                                ->get();
        $sub_varian = DB::table('sub_varian')->where('produk_id',$id_produk)->get();

        $data = [
            'produk' => $produk,
            'varian' => $varian,
            'sub_varian' => $sub_varian,
            'produk_varian' => $produk_varian
        ];

        return view('admin.produk.tampil_varian_produk',$data);
    }

    public function save_edit_produk(Request $request){
        $id_produk = $request->id_produk;
        $nama_produk = $request->nama;
        $kategori = $request->kategori;
        $stok = $request->stok;
        $min_order = $request->min_order;
        $harga_normal = $request->harga_normal;
        $harga_coret = $request->harga_coret;
        $berat = $request->berat;
        $deskripsi = $request->deskripsi;
        $gambar = $request->file('gambar');

        $data_produk = [
            'user_id' => Auth::user()->id,
            'kategori_id' => $kategori,
            'nama_produk' => $nama_produk,
            'stok' => $stok,
            'min_order' => $min_order,
            'harga_normal' => $harga_normal,
            'harga_coret' => $harga_coret,
            'deskripsi' => $deskripsi,
            'berat' => $berat
        ];
        DB::table('produk')->where('id_produk',$id_produk)->update($data_produk);
        if($gambar != null){
            foreach($gambar as $g){
                $nama_gambar = rand().'.'.$g->getClientOriginalName();
                $g->move('gambar_produk',$nama_gambar);
                DB::table('gambar_produk')->insert([
                    'user_id' => Auth::user()->id,
                    'produk_id' => $id_produk,
                    'nama_gambar' => $nama_gambar
                ]);
            }
        }

        if(isset($request->stok_varian)){
            foreach($request->stok_varian as $key => $sv){
                DB::table('produk_varian')->where('id_produk_variasi',$key)->update(['stok' => $sv]);
            }
        }
        if(isset($request->harga_normal_varian)){
            foreach($request->harga_normal_varian as $key_1 => $hn){
                DB::table('produk_varian')->where('id_produk_variasi',$key)->update(['harga_normal' => $hn]);
            }
        }
        if(isset($request->harga_coret_varian)){
            foreach($request->harga_coret_varian as $key_2 => $hc){
                DB::table('produk_varian')->where('id_produk_variasi',$key)->update(['harga_coret' => $hc]);
            }
        }
       
        return redirect('Admin/daftar_produk');
    }

    public function hapus_varian_produk(Request $request){
        $id_varian = $request->id_varian;
        $id_produk = $request->id_produk;
        //Hapus Varian
        DB::table('varian')->where('id_varian',$id_varian)->delete();
        //Hapus Produk Varian berdasarkan id varian
        DB::table('produk_varian')->where('varian_id',$id_varian)->delete();


        $produk_varian = DB::table('produk_varian')
                                ->leftJoin('varian','produk_varian.varian_id','varian.id_varian')
                                ->leftJoin('sub_varian','produk_varian.sub_varian_id','sub_varian.id_sub_varian') 
                                ->where('produk_varian.produk_id',$id_produk)
                                ->get();
        $sub_varian = DB::table('sub_varian')->where('produk_id',$id_produk)->get();
        $produk = DB::table('produk')->where('id_produk',$id_produk)->first();
        $varian = DB::table('varian')->where('produk_id',$id_produk)->get();

        $data = [
            'produk' => $produk,
            'varian' => $varian,
            'sub_varian' => $sub_varian,
            'produk_varian' => $produk_varian
        ];

        return view('admin.produk.tampil_varian_produk',$data);
    }

    public function hapus_sub_varian_produk(Request $request){
        $id_sub_varian = $request->id_sub_varian;
        $id_produk = $request->id_produk;
        //Hapus Sub Varian
        DB::table('sub_varian')->where('id_sub_varian',$id_sub_varian)->delete();
        //Hapus Produk Varian berdasarkan id sub varian
        DB::table('produk_varian')->where('sub_varian_id',$id_sub_varian)->delete();


        $produk_varian = DB::table('produk_varian')
                                ->leftJoin('varian','produk_varian.varian_id','varian.id_varian')
                                ->leftJoin('sub_varian','produk_varian.sub_varian_id','sub_varian.id_sub_varian') 
                                ->where('produk_varian.produk_id',$id_produk)
                                ->get();
        $sub_varian = DB::table('sub_varian')->where('produk_id',$id_produk)->get();
        $produk = DB::table('produk')->where('id_produk',$id_produk)->first();
        $varian = DB::table('varian')->where('produk_id',$id_produk)->get();

        $data = [
            'produk' => $produk,
            'varian' => $varian,
            'sub_varian' => $sub_varian,
            'produk_varian' => $produk_varian
        ];

        return view('admin.produk.tampil_varian_produk',$data);

    }

    public function hapus_gambar_produk(Request $request){
        $id_gambar = $request->id_gambar;
        $id_produk = $request->id_produk;

        $hapus = DB::table('gambar_produk')->where('id_gambar',$id_gambar)->first();

        //Hapus file gambar
        File::delete('gambar_produk/'.$hapus->nama_gambar);
        //Hapus Database Slider
        DB::table('gambar_produk')->where('id_gambar',$id_gambar)->delete();

        $gambar = DB::table('gambar_produk')->where('produk_id',$id_produk)->get();
        


        return view('admin.produk.tampil_gambar_produk',compact('gambar'));
    }
}
