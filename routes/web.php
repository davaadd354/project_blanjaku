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
// Route::get('/posts', 'PostsController@index');
// Route::post('/post/store', 'PostsController@store');
// Route::get('/posts/{id?}', 'PostsController@show');
// Route::post('/posts/update/{id?}', 'PostsController@update');
// Route::get('/post/delete/{id?}', 'PostsController@destroy');

// Route::view('/{any}', 'app')->where('any', '.*');

	
Route::apiResource('/coba', 'Api\CobaController');