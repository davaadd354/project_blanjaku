@if(count($varian) == 0)
            <p>Varian produk belum tersedia.</p>
            <span onclick="tambah_varian()" class="btn btn-success">Tambahkan Varian Produk</span>
            @else
            <div class="row">
                <div class="col-md-6">
                <div class="mb-3">
                        <label for="label_varian" class="form-label">Nama Varian</label>
                        <input type="text" class="form-control" id="label_varian" name="label_varian" value="{{$produk->label_varian}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                            <label for="label_sub_varian" class="form-label">Nama Sub Varian</label>
                            <input type="text" class="form-control" id="label_sub_varian" name="label_sub_varian" value="{{$produk->label_sub_varian}}">   
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h6 style="font-size:12px"><b>Varian</b></h6>
                    <p style="font-size:10px">tambahkan pilihan varian produk sesuai kebutuhan, maksimal 5 varian per produk</p>
                </div>
                <div class="col-md-8" id="varian_produk">
                    <span id="tambah_varian_produk" onclick="tambah_varian_produk()" class="btn btn-success">tambah <i class="fas fa-plus-circle"></i></span>
                    @if(count($varian) > 0)
                        @foreach($varian as $v)
                        <div class="btn btn-info">{{$v->nama_varian}} <span class="ml-2" onclick="hapus_varian('{{$v->id_varian}}')"><i class="fa fa-window-close" aria-hidden="true"></i></span></div>
                        @endforeach
                    @endif
                </div>
                <div class="col-md-4">
                    <h6 style="font-size:12px"><b>Sub Varian</b></h6>
                    <p style="font-size:10px">tambahkan pilihan sub varian produk sesuai kebutuhan, maksimal 5 sub varian</p>
                </div>
                <div class="col-md-8" id="sub_varian_produk">
                        @if(count($varian) > 0)
                            <span id="tambah_sub_varian" onclick="tambah_sub_varian()" class="btn btn-success">tambah <i class="fas fa-plus-circle"></i></span>
                            @if(count($sub_varian) > 0)
                                @foreach($sub_varian as $sv)
                                <div class="btn btn-info">{{$sv->nama_sub_varian}} <span class="ml-2" onclick="hapus_sub_varian('{{$sv->id_sub_varian}}')"><i class="fa fa-window-close" aria-hidden="true"></i></span></div>
                                @endforeach
                            @endif
                        @else
                            <p style="color:red; font-size:12px;"><i>tambahkan varian produk terlebih dahulu</i></p>
                        @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" style="text-align: center;">
                    <thead>
                        <tr>
                        <th rowspan="2" scope="col">No</th>
                        <th rowspan="2" scope="col">Varian</th>
                        <th rowspan="2" scope="col">Sub Varian</th>
                        <th rowspan="2" scope="col">stok</th>
                        <th colspan="2" scope="col">Harga</th>
                        </tr>
                        <tr>
                            <th>Harga Normal</th>
                            <th>Harga Diskon</th>
                        </tr>
                        <?php $no = 1; ?>
                        @foreach($produk_varian as $pv )
                        <tr>
                            <td>{{$no++}}</th>
                            <td>{{$pv->nama_varian}}</td>
                            <td>{{$pv->nama_sub_varian}}</td>
                            <td><input type="number" name="stok_varian[{{$pv->id_produk_variasi}}]" value="{{$pv->stok}}" class="form-control"></td>
                            <td><input type="number" name="harga_normal_varian[{{$pv->id_produk_variasi}}]" value="{{$pv->harga_normal}}" class="form-control"></td>
                            <td><input type="number" name="harga_coret_varian[{{$pv->id_produk_variasi}}]" value="{{$pv->harga_coret}}" class="form-control"></td>
                        </tr>
                        @endforeach
                       
                    </thead>
                </table>
            </div>
            @endif