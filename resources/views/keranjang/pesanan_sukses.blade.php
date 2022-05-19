@extends('layouts.app')

@section('content')
<h1 class="text-center">{{$pesanan->orderid}}</h1>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Pembayaran</h3>
           <div class="card">
               <div class="card-body">
                   <div class="row">
                       <div class="col-12">
                            <h4>Mohon lakukan pembayaran sejumlah </h4>
                       </div>
                        <div class="col-12">
                            <h6>{{"Rp " . number_format($bayar->total,2,',','.')}}</h6>
                        </div>
                        @if($bayar->metode_bayar == 1)
                            <div class="col-12 mt-5">
                                <h4>Silahkan transfer pembayaran ke rekening berikut:</h4>
                            </div>
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div class="col-12">
                                        <b><h4>Bank Jateng: 2011194683</h4></b>
                                    </div>
                                    <div class="col-12">
                                        <h5>a/n Dafa Aditya Saputra</h5>
                                    </div>
                                    <div class="col-12">
                                        <h5>KCP Wonogiri</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <h4><b>PENTING:</b></h4>
                            </div>
                            <div class="col-12">
                                <ul>
                                    <li>
                                        <h5>Mohon lakukan pembayaran dalam <b> 1 x 24 jam </b></h5>
                                    </li>
                                    <li><h5>Apabila sudah transfer dan status pembayaran belum berubah, mohon konfirmasi pembayaran manual di bawah</h5></li>
                                    <li><h5>Pesanan akan dibatalkan secara otomatis jika Anda tidak melakukan pembayaran.</h5></li>
                                </ul>
                            </div>
                            <div class="col-10 offset-1 btn btn-success mb-2 mt-5">Konfirmasi Pembayaran</div>
                            <div class="col-10 offset-1 btn btn-danger">Bayar Nanti</div>
                            
                        @elseif($bayar->metode_bayar == 2)
                            <div class="col-12">
                                <i><h5>Lakukan pembayaran setelah barang sampai ditangan anda</h5></i>
                                <div class="col-10 offset-1 btn btn-danger">Kembali Belanja</div>
                            </div>
                        @else
                            <form action="{{url('bayar')}}" method="post">
                                @csrf
                                <input type="number" name="id_bayar" value="{{$bayar->id}}" hidden>
                                <div class="row">
                                    <div class="col-12 mb-2 mt-5">
                                        <button type="submit" class="btn btn-success" style="width:100%">Bayar Sekarang</button>
                                    </div>
                                
                                <div class="col-12">
                                    <a href="#" class="btn btn-danger" style="width:100%">Bayar Nanti</a>
                                </div>
                                </div>
                                
                            </form>
                        @endif
                        
                   </div>
               </div>
           </div>
        </div>
        <div class="col-md-6">
            <h3>Informasi Pengiriman</h3>
            <div class="card">
               <div class="card-body">
                   <div class="row">
                       <div class="col-md-6">
                           <h4>Nama Penerima</h4>
                           <h6>{{$alamat->nama_penerima}}</h6>
                       </div>
                       <div class="col-md-6">
                           <h4>Nomor Telepon</h4>
                           <h6>0{{$alamat->no_hp}}</h6>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-6 mt-2">
                           <h4>Alamat Lengkap</h4>
                            <h6>
                                {{$alamat->alamat_lengkap}},{{$alamat->kecamatan}}
                            </h6>
                            <h6>{{$alamat->kabupaten}},{{$alamat->provinsi}}</h6>
                            <h6>Kode POS {{$alamat->kode_pos}}</h6>
                       </div>
                   </div>
               </div>
           </div>
           <h3 class="mt-2">Produk Pesanan</h3>
           @foreach($keranjang as $k)
           <div class="card mb-2">
               <div class="card-body">
                   <div class="row">
                        <div class="col-md-3">
                            <img class="img-fluid" src="{{asset('gambar_produk/'.$k->nama_gambar)}}" alt="$k->nama_gambar">
                        </div>
                        <div class="col-md-6">
                            <h4>{{$k->nama_produk}}</h4>
                        </div>
                        <div class="col-md-3">
                            <h6>{{$k->jumlah}}X {{"Rp " . number_format($k->harga_produk,2,',','.')}}</h6>
                        </div>
                   </div>
               </div>
           </div>
           @endforeach
        </div>
    </div>
</div>

@endsection