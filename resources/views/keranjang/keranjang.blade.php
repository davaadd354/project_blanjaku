@extends('layouts.app')

@section('content')
<h2 class="text-center">
    Keranjang Belanja
    <div class="container" id="data_keranjang">
        <form action="{{url('proses_pesanan')}}" method="post">
            {{csrf_field()}}
        <div class="row my-5">
            @foreach($keranjang as $key => $k)
            <?php
                $stok_produk = 0;
               $produk_varian = \DB::table('produk_varian')->where('id_produk_variasi',$k->produk_varian_id)->first();
               if($produk_varian == null){
                    $stok_produk = $k->stok;
               }else{
                   $stok_produk = $produk_varian->stok;
               }
            ?>
            <div class="form-check">
                <input  type="checkbox" name="cart[]" value="{{$k->id_cart}}" class="check_box">
            </div>
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <?php $gambar = \DB::table('gambar_produk')->where('produk_id',$k->produk_id)->first(); ?>
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-md-4">
                                    <div class="row justify-content-center">
                                   
                                        <div class="col-8">
                                            <img class="img-fluid" style="border-radius: 15px;" src="{{asset('gambar_produk/'.$gambar->nama_gambar)}}" alt="{{$gambar->nama_gambar}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-sm-6 col-md-8">
                                    <div class="row">
                                        <div class="col-md-5 text-start">
                                            <h3><b>{{$k->nama_produk}}</b></h3>
                                            @if($k->varian_id != null)
                                                @if($k->sub_varian_id != null)
                                                    <p style="font-size: 14px;">{{$k->label_varian}}:{{$k->nama_varian}}  {{$k->label_sub_varian}}:{{$k->nama_sub_varian}}</p>
                                                @else
                                                    <p style="font-size: 14px;">{{$k->label_varian}}:{{$k->nama_varian}}</p>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" min="1" max="{{$stok_produk}}" onkeyup="ubah_jumlah('{{$k->harga_produk}}','{{$k->id_cart}}',this.value,'{{$key}}')" class="form-control " id="jumlah[{{$k->id_cart}}]" required value="{{$k->jumlah}}">
                                        </div>
                                        <div class="col-md-2">
                                            <span id="{{$k->id_cart}}" style="font-size: 14px;">{{"Rp " . number_format($k->harga_produk * $k->jumlah,2,',','.')}}</span>
                                            <input type="number" value="{{$k->harga_produk}}" name="jumlah_produk[{{$k->id_cart}}]"  class="harga_jumlah" hidden>
                                        </div>
                                        <div class="col-md-1"><span onclick="hapus_cart('{{$k->id_cart}}')" class="btn btn-danger"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/filled-trash.png"/></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if(count($keranjang) > 0)
        <div class="row">
            <div class="col-md-4 offset-md-8">
                <h5><b id="harga_total">Total Harga : {{"Rp " . number_format($total_harga,2,',','.')}}</b></h5>
                <input type="number" value="{{$total_harga}}" id="total_harga" hidden> 
            </div>
        </div>    
        @endif
        <div class="row">
            <div class="col-md-4 offset-md-8">
                <a href="{{url('daftar_produk')}}" class="btn btn-primary">Kembali Belanja</a>
                <button type="submit" class="btn btn-success">lanjutkan Pembayaran</button>
            </div>
        </div>    
    </form>
    </div>
</h2>
<script>
var data = 1000; 
 function ubah_jumlah(harga_produk,id,jumlah,key){
    if(jumlah != '' ){
        var total = harga_produk * jumlah;
    }else{
        var total = 0;
    }
    
    function rupiah(nominal){
        var	reverse = nominal.toString().split('').reverse().join(''),
	ribuan 	= reverse.match(/\d{1,3}/g);
	ribuan	= ribuan.join('.').split('').reverse().join('');

    return ribuan;
    }

    document.getElementById(id).innerHTML = "Rp "+ rupiah(total) +",00";
    var harga = document.getElementsByClassName("harga_jumlah")[key].value;
    
    var total_harga = document.getElementById('total_harga').value;
    var total_harga_new = (total_harga - harga) + total ;
    var tampil_total_harga = document.getElementById('total_harga').value = total_harga_new;
    document.getElementById('harga_total').innerHTML = "Rp "+ rupiah(tampil_total_harga) +",00";
    var coba = document.getElementsByClassName("harga_jumlah")[key].value = total;
    
 }
 function hapus_cart(int){
     var tanya = confirm('kamu yakin menghapus produk dari keranjang?');
     if(tanya == true){
        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/hapus_produk_cart')}}";
        var formData = {
            '_token': token,
            'id_cart': int
        };
        $.ajax({
            method: 'POST',
            url: my_url,
            data: formData,
            success: function (data) {
                alert('produk berhasil dihapus dari keranjang');
                $('#data_keranjang').html(data);
                
        }
    });
     }
   
 }
</script>
@endsection