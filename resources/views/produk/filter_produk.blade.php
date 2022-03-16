@if(count($produk) == 0)
<h4 class="text-center"><i>Produk yang anda cari tidak ditemukan</i></h4>
@endif
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
                                <a href="#" class="btn btn-primary mr-2">lihat</a><button class="btn btn-success"><img width="24px" src="https://img.icons8.com/external-bearicons-glyph-bearicons/64/000000/external-cart-call-to-action-bearicons-glyph-bearicons.png"/></button>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>