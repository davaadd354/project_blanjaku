<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//Akun
Route::get('akun_saya','HomeController@akun_saya')->name('akun_saya');
Route::get('profil','HomeController@profil')->name('profil');
Route::post('edit_profil','HomeController@edit_profil')->name('edit_profil');
Route::post('data_tampil_profil','HomeController@data_tampil_profil')->name('data_tampil_profil');
Route::post('data_tampil_alamat','HomeController@data_tampil_alamat')->name('data_tampil_alamat');
Route::post('data_tampil_notif','HomeController@data_tampil_notif')->name('data_tampil_notif');
Route::post('data_tampil_pesanan','HomeController@data_tampil_pesanan')->name('data_tampil_pesanan');
Route::post('data_tampil_voucher','HomeController@data_tampil_voucher')->name('data_tampil_voucher');
Route::post('tambah_alamat_user','HomeController@tambah_alamat_user')->name('tambah_alamat_user');
Route::post('data_tampil_kabupaten','HomeController@data_tampil_kabupaten')->name('data_tampil_kabupaten');
Route::post('data_tampil_kecamatan','HomeController@data_tampil_kecamatan')->name('data_tampil_kecamatan');
Route::post('save_tambah_alamat','HomeController@save_tambah_alamat')->name('save_tambah_alamat');
//Halaman Admin
Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('/Admin/dashboard','AdminController@dashboard')->name('dashboard');
    
    Route::get('/Admin/data_slider','AdminController@data_slider')->name('data_slider');
    Route::get('/Admin/home_slider','AdminController@home_slider')->name('home_slider');
    Route::post('hapus_slider','AdminController@hapus_slider')->name('hapus_slider');
    Route::post('tambah_slider','AdminController@tambah_slider')->name('tambah_slider');
    Route::post('ubah_slider','AdminController@ubah_slider')->name('ubah_slider');
    Route::post('edit_slider_save','AdminController@edit_slider_save')->name('edit_slider_save');

    Route::get('Admin/kategori_produk','AdminController@kategori_produk')->name('kategori_produk');
    Route::get('/Admin/data_kategori','AdminController@data_kategori')->name('data_kategori');
    Route::post('tambah_kategori','AdminController@tambah_kategori')->name('tambah_kategori');
    Route::post('hapus_kategori','AdminController@hapus_kategori')->name('hapus_kategori');
    Route::post('ubah_kategori','AdminController@ubah_kategori')->name('ubah_kategori');
    Route::post('edit_kategori_save','AdminController@edit_kategori_save')->name('edit_kategori_save');

    Route::get('Admin/daftar_produk','AdminController@daftar_produk')->name('daftar_produk');
    Route::post('Admin/tambah_produk','AdminController@tambah_produk')->name('tambah_produk');
    Route::post('save_tambah_produk','AdminController@save_tambah_produk')->name('save_tambah_produk');
    Route::get('tampil_data_produk','AdminController@tampil_data_produk')->name('tampil_data_produk');
    Route::get('Admin/edit_data_produk/{id}','AdminController@edit_data_produk')->name('edit_data_produk');
    Route::post('save_tambah_nama_varian','AdminController@save_tambah_nama_varian')->name('save_tambah_nama_varian');
    Route::post('save_tambah_sub_varian','AdminController@save_tambah_sub_varian')->name('save_tambah_sub_varian');
    Route::post('save_edit_produk','AdminController@save_edit_produk')->name('save_edit_produk');
    Route::post('hapus_varian_produk','AdminController@hapus_varian_produk')->name('hapus_varian_produk');
    Route::post('hapus_sub_varian_produk','AdminController@hapus_sub_varian_produk')->name('hapus_sub_varian_produk');
    Route::post('hapus_gambar_produk','AdminController@hapus_gambar_produk')->name('hapus_gambar_produk');

    Route::get('Admin/data_kurir','AdminController@data_kurir')->name('data_kurir');
  });

  //Kategori Produk
  Route::get('kategori_produk/{nama}/{id}','ProdukController@kategori_produk')->name('kategori_produk');
  Route::post('filter_produk_kategori','ProdukController@filter_produk_kategori')->name('filter_produk_kategori');

  //Daftar Produk
  Route::get('daftar_produk/{keyword?}','ProdukController@daftar_produk')->name('daftar_produk');
  Route::post('filter_produk','ProdukController@filter_produk')->name('filter_produk');

  //Detail Produk
  Route::get('detail_produk/{id}','ProdukController@detail_produk')->name('detail_produk');
  Route::post('tampil_gambar_utama','ProdukController@tampil_gambar_utama')->name('tampil_gambar_utama');
  Route::post('cek_sub_varian','ProdukController@cek_sub_varian')->name('cek_sub_varian');

  //Keranjang Belanja
  Route::post('input_tambah_produk_keranjang','KeranjangController@input_tambah_produk_keranjang')->name('input_tambah_produk_keranjang');
  Route::get('keranjang_belanja','KeranjangController@keranjang_belanja')->name('keranjang_belanja');
  Route::get('checkout','PesananController@checkout')->name('checkout');
  Route::post('ubah_jumlah_produk_cart','KeranjangController@ubah_jumlah_produk_cart')->name('ubah_jumlah_produk_cart');
  Route::post('hapus_produk_cart','KeranjangController@hapus_produk_cart')->name('hapus_produk_cart');
  Route::post('tambah_alamat_pengiriman','PesananController@tambah_alamat_pengiriman')->name('tambah_alamat_pengiriman');
  Route::post('tampil_alamat_pengiriman','PesananController@tampil_alamat_pengiriman')->name('tampil_alamat_pengiriman');
  Route::post('tampil_layanan_ekspedisi','PesananController@tampil_layanan_ekspedisi')->name('tampil_layanan_ekspedisi');
  //Route::post('posts/store', 'Api\PostsController@store');


	
Route::apiResource('/coba', 'Api\CobaController');