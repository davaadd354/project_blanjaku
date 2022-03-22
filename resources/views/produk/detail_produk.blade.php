@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Produk</li>
        </ol>
    </nav>
    <div class="row mb-5">
        <div class="col-md-6 mt-3">
            <div class="row justify-content-center">
                <div id="gambar_utama" class="col-12">
                    <a id="link_gambar" href="{{url('gambar_produk/gbr_asli/'.$gambar[0]->nama_gambar)}}" target="blank">
                        <img  class="img-fluid" style="margin: auto;display:block;border:1px solid black;" src="{{asset('gambar_produk/'.$gambar[0]->nama_gambar)}}" alt="{{$gambar[0]->nama_gambar}}">
                    </a>
                </div>
                @foreach($gambar as $g)
                    <div class="col-2 mt-3">
                        <img onclick="ubah_gambar('{{$g->id_gambar}}')" class="img-fluid" style="margin: auto;display:block;border:1px solid black;" src="{{asset('gambar_produk/'.$g->nama_gambar)}}" alt="{{$g->nama_gambar}}">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <h2 class="mb-md-3"><b>{{$produk->nama_produk}}</b></h2>
            <h3 class="mb-md-4">{{'Rp.'.number_format($produk->harga_normal,2,',','.')}}</h3>
            <h4 class="mb-md-4">Berat : {{number_format($produk->berat)}} <i>gram</i></h4>
            <h4 class="mb-md-4">Stok  : {{number_format($produk->stok)}} <i>pcs</i> </h4>
            <h4 class="mb-md-4">Terjual  : 0 </h4>
            <div id="tombol_tampil">
                <button onclick="tampil_input()" class="btn btn-primary">Beli Sekarang</button>
            </div>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-12">
            <h3><b>Deskripsi Produk</b></h3>
            <p>{!!$produk->deskripsi!!}</p>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
 function ubah_gambar(id_gambar){
    var token = '{{ csrf_token() }}';
                var my_url = "{{url('/tampil_gambar_utama')}}";
                var formData = {
                    '_token': token,
                    'id_gambar' : id_gambar
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    success: function (data) {
                        $('#gambar_utama').html(data);
                        //console.log(data);
                    }
                });
 }

 function tampil_input(){
    $('#tombol_tampil').html(`
    <form action="{{url('input_tambah_produk_keranjang')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input required type="number" value="{{$produk->id_produk}}" name="produk_id" hidden>
        <input required type="number" value="{{$produk->user_id}}" name="toko_id" hidden>
        @if(count($produk_varian) != 0)
            <div id="varian" class="from-group">
                <label><b>{{$produk->label_varian}}</b></label><br>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    @foreach($varian as $v)
                    <div class="mr-4">
                        <input required type="radio" onclick="cek_sub_varian({{$v->id_varian}})" class="btn-check" name="varian_id" value="{{$v->id_varian}}" id="{{$v->id_varian}}" autocomplete="off">
                        <label class="btn btn-outline-primary" for="{{$v->id_varian}}">{{$v->nama_varian}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div id="sub_varian" class="from-group">

            </div>
        @endif
        <div class="form-group">
            <label for="jumlah"><b>Jumlah</b></label>
            <input required type="number" id="jumlah" name="jumlah" class="form-control">
        </div>
        <div class="form-group">
            <label for="catatan"><b>Catatan</b></label>
            <textarea required name="catatan" id="catatan" class="form-control" cols="20" rows="5"></textarea>
        </div>
        <button class="btn btn-success" type="submit">Masukkan Keranjang</button>
    </form>
    `);
 }
 function cek_sub_varian(id){
    var token = '{{ csrf_token() }}';
    produk_id = '{{$produk->id_produk}}';
                var my_url = "{{url('/cek_sub_varian')}}";
                var formData = {
                    '_token': token,
                    'varian_id' : id,
                    'produk_id' : produk_id
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    success: function (data) {
                        $('#sub_varian').html(data);
                        console.log(data);
                    }
                });
 }

</script>
@endsection