<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use Illuminate\Support\Facades\Http;
use Exception;
use Midtrans\Snap;
use Midtrans\config;
use Midtrans\Notification;

class PesananController extends Controller
{
    public $api_key = '44a97a674b7ec3d2d3059bad6bcd4d9c';
    public function checkout(Request $request){
        $user_id = Auth::user()->id;
        $jumlah = $request->jumlah;
        $berat = 0;
        if($request->cart == null){
            return redirect('keranjang_belanja');
        }else{
            $cart = $request->cart;
            $keranjang = DB::table('cart as c')->leftJoin('produk as p','c.produk_id','p.id_produk')
                                               ->whereIn('c.id_cart',$cart) 
                                               ->get();
            foreach($keranjang as $k){
                foreach($jumlah as $key => $j){
                    if($k->id_cart == $key){   
                        DB::table('cart')->where('id_cart',$key)->update(['jumlah'=> $j]);
                        $berat += ($k->berat * $j);
                    }
                }
            }
        }
        $data_alamat = DB::table('alamat_user as a')->leftJoin('blw_prov as pr','a.id_provinsi','pr.id')
                                                    ->leftJoin('blw_kab as kb','a.id_kabupaten','kb.id')
                                                    ->leftJoin('blw_kec as kc','a.id_kecamatan','kc.id')
                                                    ->where('user_id',$user_id)
                                                    ->select(
                                                        'a.*',
                                                        'pr.nama as provinsi',
                                                        'kb.nama as kabupaten',
                                                        'kc.nama as kecamatan'
                                                    )
                                                    ->get();

        $keranjang_new = DB::table('cart as c')->leftJoin('produk as p','c.produk_id','p.id_produk')
                                               ->leftJoin('varian as v','c.varian_id','v.id_varian')
                                               ->leftJoin('sub_varian as sv','c.sub_varian_id','sv.id_sub_varian')
                                               ->leftJoin('gambar_produk as g', 'c.produk_id','g.produk_id')
                                               ->whereIn('c.id_cart',$cart)
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
                                          ->where('c.user_id',$user_id)
                                          ->where('c.status',0)
                                          ->get();
        // $client = new Client(['verify' => 'C:\home\cacert.pem',
        //                       'headers' => ['key' => '44a97a674b7ec3d2d3059bad6bcd4d9c','content-type' => 'application/x-www-form-urlencoded'],
        //                       'form_params' => [
        //                           'origin' => 501,
        //                           'destination' => 114,
        //                           'weight' => 800,
        //                           'courier' => 'jne'
        //                       ]
        //                     ]);
        
        // // $response = $client->request('GET', 'https://api.rajaongkir.com/starter/province');
        // // $coba = json_decode($response->getBody());
        // // dd($coba);

        // $response = $client->request('POST','https://api.rajaongkir.com/starter/cost');
        // $coba = json_decode($response->getBody());
        // dd($coba->rajaongkir->results[0]->costs);
        

        // $client = new Client(['verify' => 'C:\home\cacert.pem',
        //                       'headers' => ['content-type' => 'application/x-www-form-urlencoded'],
        //                       'form_params' => [
        //                           'judul' => 'Hello World',
        //                           'teks' => 'lorem ipsum dolor sit amet'
        //                       ]
        //                     ]);
        // $response = $client->request('POST','http://127.0.0.1:8080/posts/store');
        // $coba = json_decode($response->getBody());
        
        // $options = [
        //     'form_params' => [
        //         'judul' => 'Hello World',
        //         'teks' => 'lorem ipsum dolor sit amet'
        //     ]
        // ]; 
        
       
        $expedisi = DB::table('blw_kurir')->where('status',1)->get();
        $pembayaran = DB::table('pembayaran')->where('status',1)->get();

        $data = [
            'keranjang' => $keranjang_new,
            'data_alamat' => $data_alamat,
            'ekspedisi' => $expedisi,
            'berat' => $berat,
            'pembayaran' => $pembayaran
        ];
        
        return view('keranjang.checkout_pesanan',$data);
        
    }

    public function tambah_alamat_pengiriman(Request $request){
        $provinsi = DB::table('blw_prov')->get();
        return view('keranjang.tampil_tambah_alamat',compact('provinsi'));
    }

    public function tampil_alamat_pengiriman(Request $request){
        $id_alamat = $request->id_alamat;
        $alamat = DB::table('alamat_user as a')->leftJoin('blw_prov as pr','a.id_provinsi','pr.id')
                                                        ->leftJoin('blw_kab as kb','a.id_kabupaten','kb.id')
                                                        ->leftJoin('blw_kec as kc','a.id_kecamatan','kc.id')
                                                        ->where('a.id_alamat',$id_alamat)
                                                        ->select(
                                                            'a.*',
                                                            'pr.nama as provinsi',
                                                            'kb.nama as kabupaten',
                                                            'kc.nama as kecamatan'
                                                        )
                                                        ->first();

        return view('keranjang.tampil_alamat_pengiriman',compact('alamat'));
       
    }

    public function tampil_layanan_ekspedisi(Request $request){
        //$destinasi = $request->destinasi;
        $kurir = $request->kurir;
        $berat = $request->berat;
        $destinasi = DB::table('blw_kab')->where('id',$request->destinasi)->first();
        if($kurir == null){
            return response()->json('gagal');
        }else{
            $client = new Client([
                'headers' => ['key' => '42d9164584a209caad6f635480f01b35','content-type' => 'application/x-www-form-urlencoded'],
                'form_params' => [
                    'origin' => 153,
                    'originType'=>'city',
                    'destination' => $destinasi->rajaongkir,
                    'destinationType' => 'city',
                    'weight' => $berat,
                    'courier' => $kurir
                ]
              ]);
            $response = $client->request('POST','https://pro.rajaongkir.com/api/cost');
            $rajaongkir = json_decode($response->getBody());
            $layanan = $rajaongkir->rajaongkir->results[0]->costs;
            return response()->json($layanan);
        }
       
    }

    public function save_tambah_alamat_pengiriman(Request $request){
        $keterangan= $request->keterangan;
        $nama_penerima= $request->nama_penerima;
        $no_hp= $request->no_hp;
        $provinsi= $request->provinsi;
        $kabupaten= $request->kabupaten;
        $kecamatan= $request->kecamatan;
        $kode_pos= $request->kode_pos;
        $alamat_lengkap= $request->alamat_lengkap;

    $data_alamat =  DB::table('alamat_user')->insertGetId([
            'user_id' => Auth::user()->id,
            'nama_penerima' => $nama_penerima,
            'no_hp' => $no_hp,
            'id_provinsi' => $provinsi,
            'id_kabupaten' => $kabupaten,
            'id_kecamatan' => $kecamatan,
            'kode_pos' => $kode_pos,
            'alamat_lengkap' => $alamat_lengkap,
            'status' => 0,
            'keterangan' =>$keterangan
        ]);

    return response()->json($data_alamat);

    }

    public function buat_pesanan(Request $request){
        $cart = $request->cart;
        $alamat = $request->alamat;
        $id_alamat = 0;
        $kurir = $request->kurir;
        $nama_layanan_kurir = $request->nama_layanan_kurir;
        $pembayaran = $request->pembayaran;
        $nama_dropship = $request->nama_dropship;
        $telp_dropship = $request->telp_dropship;
        $alamat_dropship = $request->alamat_dropship;
        $ongkir = $request->input_ongkir;
        $total_pesanan = $request->input_total_pesanan;
        $kode_pesanan = 'BLJ_'.date('Y/m/d').'_'.rand();
        $invoice = date('Ymd').rand(000,999);
        $berat_total = $request->berat_total;
        $tgl_input = time();
       $tgl_kadaluarsa =  0;

        if($pembayaran == 1 || $pembayaran == 3){
            $tgl_kadaluarsa = time()+86400;
        }
        
       
        $id_bayar = DB::table('blw_pembayaran')->insertGetId([
            'usrid' => Auth::user()->id,
            'invoice' => $invoice,
            'total' => $total_pesanan,
            'status' => 0,
            'metode_bayar' => $pembayaran
        ]);

        if($alamat == 'tambah'){
            $alamat_new = DB::table('alamat_user')->where('user_id',Auth::user()->id)->orderBy('id_alamat','desc')->first();
            $id_alamat = $alamat_new->id_alamat;
        }else{
            $id_alamat = $alamat;
        }
        if($request->nama_dropship){
            
           $transaksi_id =  DB::table('pesanan')->insertGetId([
                'usrid' => Auth::user()->id,
                'orderid' => $kode_pesanan,
                'nama_dropship' => $nama_dropship,
                'alamat_dropship' => $alamat_dropship,
                'telp_dropship' => $telp_dropship,
                'alamat_id' => $id_alamat,
                'berat' => $berat_total,
                'ongkir' => $ongkir,
                'kurir' => $kurir,
                'layanan' => $nama_layanan_kurir,
                'idbayar' => $id_bayar,
                'status' => 0,
                'tgl' => $tgl_input,
                'kadaluarsa' => $tgl_kadaluarsa
            ]);
        }else{
           $transaksi_id =  DB::table('pesanan')->insertGetId([
                'usrid' => Auth::user()->id,
                'orderid' => $kode_pesanan,
                'alamat_id' => $id_alamat,
                'berat' => $berat_total,
                'ongkir' => $ongkir,
                'kurir' => $kurir,
                'layanan' => $nama_layanan_kurir,
                'idbayar' => $id_bayar,
                'status' => 0,
                'tgl' => $tgl_input,
                'kadaluarsa' => $tgl_kadaluarsa
            ]);
        }

        foreach($cart as $c){
            DB::table('cart')->where('id_cart',$c)->update(['id_transaksi' => $transaksi_id]);
        }

        $pesanan = DB::table('pesanan')->where('id',$transaksi_id)->first();
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


        return view('keranjang.pesanan_sukses',$data);
        
    }

    public function bayar(Request $request){
        $bayar = DB::table('blw_pembayaran')->where('id',$request->id_bayar)->first();
        $user_id = Auth::user()->id;
        $user_detail = DB::table('user_detail')->where('user_id',$user_id)->first();

        //Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //Buat array untuk dikirim ke midtrans
        $parameter = array(
            'transaction_details' => array(
                'order_id' => $bayar->invoice,
                'gross_amount' => $bayar->total,
            ),
            'customer_details' => array(
                "first_name" => $user_detail->nama_depan,
                "last_name" => $user_detail->nama_belakang,
                "email" => Auth::user()->email,
            )
        );

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($parameter)->redirect_url;
            
            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
          }
          catch (Exception $e) {
            echo $e->getMessage();
          }
    }

    public function bayar_callback(){
         //Konfigurasi Midtrans
         Config::$serverKey = config('services.midtrans.serverKey');
         Config::$isProduction = config('services.midtrans.isProduction');
         Config::$isSanitized = config('services.midtrans.isSanitized');
         Config::$is3ds = config('services.midtrans.is3ds');

         $notification = new Notification();

         $status = $notification->transaction_status;
         $type = $notification->payment_type;
         $fraud = $notification->fraud_status;
         $order_id = $notification->order_id;



    }
}
