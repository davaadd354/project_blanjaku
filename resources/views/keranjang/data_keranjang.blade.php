<form action="{{url('proses_pesanan')}}" method="post">
            {{csrf_field()}}
        <div class="row my-5">
            @foreach($keranjang as $k)
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
                                        <input type="number" min="1"  onkeyup="ubah_jumlah('{{$k->harga_produk}}','{{$k->id_cart}}',this.value,'{{$key}}')" class="form-control " id="jumlah[{{$k->id_cart}}]" required value="{{$k->jumlah}}">
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
        