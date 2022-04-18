<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use Illuminate\Support\Facades\Http;
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
                                               ->whereIn('c.id_cart',$cart) 
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
        
        $client = new Client(["verify" => "C:\home\cacert.pem"]);
        // $options = [
        //     'form_params' => [
        //         'judul' => 'Hello World',
        //         'teks' => 'lorem ipsum dolor sit amet'
        //     ]
        // ]; 
        $response = $client->request('GET','https://rest.blanjaku.xyz/api/products');
        $testing = $response->getBody();
        dd(json_decode($testing));
       
        $expedisi = DB::table('blw_kurir')->where('status',1)->get();

        $data = [
            'keranjang' => $keranjang_new,
            'data_alamat' => $data_alamat,
            'ekspedisi' => $expedisi,
            'berat' => $berat
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
        
        $client = new Client(['verify' => 'C:\home\cacert.pem',
                              'headers' => ['key' => '44a97a674b7ec3d2d3059bad6bcd4d9c','content-type' => 'application/x-www-form-urlencoded'],
                              'form_params' => [
                                  'origin' => 153,
                                  'destination' => $destinasi->rajaongkir,
                                  'weight' => $berat,
                                  'courier' => $kurir
                              ]
                            ]);
        $response = $client->request('POST','https://api.rajaongkir.com/starter/cost');
        $rajaongkir = json_decode($response->getBody());
        $layanan = $rajaongkir->rajaongkir->results[0]->costs;
        return response()->json($layanan);
    }
}
