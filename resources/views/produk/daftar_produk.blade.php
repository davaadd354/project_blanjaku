@extends('layouts.app')

@section('content')

<style>
    .ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical
        }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-3">
        <img width="18px" src="https://img.icons8.com/ios-filled/50/000000/filter--v1.png"/><span><b>Filter Produk</b></span>
        <br><br>
        <span><b>Kategori</b></span><br>
        <select class="form-control" id="kategori" name="kategori">
            <option>Pilih...</option>
                @foreach($kategori as $k)
                    <option value="{{$k->id_kategori}}">{{$k->nama_kategori}}</option>
                @endforeach
        </select><br><br>
        <span><b>Batas Harga</b></span><br>
        <label for="harga_min">Harga Min</label>
        <input type="number" name="harga_min" class="form-control" id="harga_min">
        <br>
        <label for="harga_max">Harga Max</label>
        <input type="number" name="harga_max" class="form-control" id="harga_max">
        <br><br>
        <span><b>Metode Pembayaran</b></span>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="cod" >
            <label class="form-check-label" for="cod">
            COD (Cash On Delivery)
            </label>
      </div>
      <br><br>
      <button onclick="filter_produk()" class="btn btn-primary">Filter</button>
        </div>
        <div class="col-md-9" id="produk">
            <div class="row justify-content-center">
                @foreach($produk as $p)
                <?php 
                $gambar = \DB::table('gambar_produk')->where('produk_id',$p->id_produk)->get();
                $produk_varian = \DB::table('produk_varian')->where('produk_id',$p->id_produk)->get();
                $stok = 0;
                foreach($produk_varian as $pv){
                    $stok += $pv->stok;
                }
                ?>
                <a href="{{url('detail_produk/'.$p->id_produk)}}">
                    <div class="col-md-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <img class=" mb-2" style="width: 150px;height:150px" src="{{asset('gambar_produk/'.$gambar[0]->nama_gambar)}}" alt="{{$gambar[0]->nama_gambar}}">
                                <div style="height: 30px; white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    display: -webkit-box;
                                    -webkit-line-clamp: 2;
                                    -webkit-box-orient: vertical">
                                    <p> {{$p->nama_produk}}</p>   
                                </div>
                                <span>{{"Rp " . number_format($p->harga_coret,2,',','.')}};</span><br>
                                <span>0 Terjual</span><br>
                                <a href="{{url('detail_produk/'.$p->id_produk)}}" class="btn btn-primary mr-2">lihat</a><button class="btn btn-success"><img width="24px" src="https://img.icons8.com/external-bearicons-glyph-bearicons/64/000000/external-cart-call-to-action-bearicons-glyph-bearicons.png"/></button>
                            </div>
                        </div>
                    </div>
                </a>
                   
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    function filter_produk(){
       var harga_min = $('#harga_min').val();
       var harga_max = $('#harga_max').val();
       var kategori = $('#kategori').val();
       var token = '{{ csrf_token() }}';
                var my_url = "{{url('/filter_produk')}}";
                var formData = {
                    '_token': token,
                    'harga_min' : harga_min,
                    'harga_max' : harga_max,
                    'id_kategori' : kategori
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    success: function (data) {
                        $('#produk').html(data);
                        //console.log(data);
                    }
                });
       
    }
   
</script>

@endsection