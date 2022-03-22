@extends('layouts.admin_template')

@section('content')
<h1 class="text-center">Edit Produk</h1>
<form id="edit_data_produk" action="{{url('save_edit_produk')}}" method="post" enctype="multipart/form-data">
{{csrf_field()}}
<div class="container">
    <div class="card mb-4">
        <div class="card-header"><h4>Nama & Kategori Produk</h4></div>
        <div class="card body px-3">
                <div class="mb-3">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input type="number" name="id_produk" value="{{$produk->id_produk}}" hidden>
                        <input required type="text" class="form-control" name="nama" id="nama" value="{{$produk->nama_produk}}">
                    </div>
                </div>
                <div class="mb-5">
                    <label>Kategori</label>
                    <select required class="form-select" name="kategori">
                        <option>Pilih...</option>
                        @foreach($kategori as $k)
                        <option <?php echo $k->id_kategori == $produk->kategori_id? 'selected' : '' ; ?> value="{{$k->id_kategori}}">{{$k->nama_kategori}}</option>
                        @endforeach
                    </select>
                </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header"><h4>Harga & Stok Produk</h4></div>
        <div class="card-body px-3">
            <div class="mb-3">
                <div class="form-group">
                    <label for="stok" class="form-label">Stok Barang</label>
                    @if(count($varian) == 0)
                    <input required type="number" class="form-control" name="stok" id="stok" value="{{$produk->stok}}">
                    @else
                    <input required type="number" class="form-control" name="stok" id="stok" value="{{$produk->stok}}">
                    @endif
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="min_order" class="form-label">Minimal Order</label>
                    <input required type="number" class="form-control" name="min_order" id="min_order" value="{{$produk->min_order}}">
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="harga_normal" class="form-label">Harga Normal</label>
                    <input required type="number" class="form-control" name="harga_normal" id="harga_normal" value="{{$produk->harga_normal}}">
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="harga_coret" class="form-label">Harga Coret</label>
                    <input required type="number" class="form-control" name="harga_coret" id="harga_coret" value="{{$produk->harga_coret}}">
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header"><h4>Deskripsi Produk</h4></div>
        <div class="card-body px-3">
            <div class="mb-3">
                <div class="form-group">
                    <label for="berat" class="form-label">Berat Produk(gram)</label>
                    <input required type="number" class="form-control" name="berat" id="berat" value="{{$produk->berat}}">
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" class="form-control" name="deskripsi" rows="10" cols="50">{{$produk->deskripsi}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h4>Gambar Produk</h4>
        </div>
        <div class="card-body">
        <div class="mb-3">
                <div id="gambar_produk">
                    @foreach($gambar as $g)
                        <img class="data_gambar"  src="{{asset('gambar_produk/'.$g->nama_gambar)}}" alt="{{$g->nama_gambar}}" width="100px" class="mb-2 mr-2">
                        <img onclick="hapus_gambar('{{$g->id_gambar}}')" src="https://img.icons8.com/material-rounded/24/fa314a/filled-trash.png"/>
                    @endforeach
                </div>
                <div class="row" id="form_gambar_detail">
                    <div class="col-4">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="file_upload" id="file" name="gambar[]">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <button type="button" onclick="minus()" class="btn btn-floating btn-danger btn-block mt-2"
                            style="text-align: center;"><i class="fas fa-minus-circle float-left"></i></button>
                    </div>
                    <div class="col-1">
                        <button type="button" onclick="plus()"
                            class="btn btn-floating btn-info btn-block float-right mt-2" style="text-align: center;"><i
                                class="fas fa-plus-circle"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h4>Varian Produk</h4>
        </div>
        <div id="varian" class="card-body">
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
                            <div class="btn btn-info varian_name">{{$v->nama_varian}} <span class="ml-2" onclick="hapus_varian('{{$v->id_varian}}')"><i class="fa fa-window-close" aria-hidden="true"></i></span></div>
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
                                    <div class="btn btn-info sub_varian_name">{{$sv->nama_sub_varian}} <span class="ml-2" onclick="hapus_sub_varian('{{$sv->id_sub_varian}}')"><i class="fa fa-window-close" aria-hidden="true"></i></span></div>
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
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Simpan</button>
    <a href="{{url('Admin/daftar_produk')}}" class="btn btn-danger">Batal</a>
</div>
</form>

<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   var konten = document.getElementById("deskripsi");
     CKEDITOR.replace(konten,{
     language:'en-gb'
   });
   CKEDITOR.config.allowedContent = true;
</script>
<script>
    function plus() {
        $('#form_gambar_detail').append(
            `<div class="col-4" id="form_gambar_detail_upload">
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="file_upload" id="file" name="gambar[]">
                </div>
            </div>
        </div>`
        );
    }

    function minus() {
        let form_gambar_detail = document.getElementById("form_gambar_detail");
        let form_gambar_detail_upload = document.getElementById("form_gambar_detail_upload");
        form_gambar_detail.removeChild(form_gambar_detail_upload);
    }

    function tambah_varian(){
        $('#varian').html(
            `
            <div class="row">
                <div class="col-md-6">
                <div class="mb-3">
                        <label for="label_varian" class="form-label">Nama Varian</label>
                        <input type="text" class="form-control" id="label_varian" name="label_varian">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                            <label for="label_sub_varian" class="form-label">Nama Sub Varian</label>
                            <input type="text" class="form-control" id="label_sub_varian" name="label_sub_varian">   
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
                </div>
                <div class="col-md-4">
                    <h6 style="font-size:12px"><b>Sub Varian</b></h6>
                    <p style="font-size:10px">tambahkan pilihan sub varian produk sesuai kebutuhan, maksimal 5 sub varian</p>
                </div>
                <div class="col-md-8">
                    <!-- <button class="btn btn-success">tambah <i class="fas fa-plus-circle"></i></button> -->
                    <p style="color:red; font-size:12px;"><i>tambahkan varian produk terlebih dahulu</i></p>
                </div>
            </div>

       `
        )                 
    }

    function tambah_varian_produk(){
        //$('#varian_produk').hide();
        var data_varian = document.getElementsByClassName('varian_name').length;
        if(data_varian >= 5){
            alert('varian produk maksimal 5');
        }else{
            $('#varian_produk').html(`
            <div class="row">
                <div class="col-md-9">
                    <div class="mb-3">
                        <input type="text" required class="form-control" id="varian_nama" name="varian_nama">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <button type="button" onclick="save_tambah_varian()" class="btn btn-success" ><i  class="fas fa-plus-circle"></i></button>
                    </div>
                </div>
            </div>
        `);
        }
       
    }

    function tambah_sub_varian(){
        var data_sub_varian = document.getElementsByClassName('sub_varian_name').length;
        if(data_sub_varian >= 5){
            alert(' sub varian tidak boleh lebih dari 5');
        }else{
            $('#sub_varian_produk').html(`
        <div class="row">
                <div class="col-md-9">
                    <div class="mb-3">
                        <input type="text" required class="form-control" id="sub_varian_nama" name="sub_varian_nama">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <button type="button" onclick="save_tambah_sub_varian()" class="btn btn-success" ><i  class="fas fa-plus-circle"></i></button>
                    </div>
                </div>
            </div>
        `);
        }
       
    }

  

</script>
<script>
  function save_tambah_varian(){
       var nama_varian = $('#varian_nama').val();
       var label_varian = $('#label_varian').val();
       var label_sub_varian = $('#label_sub_varian').val();

       if(nama_varian == '' || label_varian == '' || label_sub_varian == ''){
           alert('Data belum lengkap,mohon diperiksa kembali!');
       }else{
        var token = '{{ csrf_token() }}';
        var id_produk = '{{$produk->id_produk}}';
                var my_url = "{{url('/save_tambah_nama_varian')}}";
                var formData = {
                    '_token': token,
                    'id_produk': id_produk,
                    'nama_varian': nama_varian,
                    'label_varian': label_varian,
                    'label_sub_varian': label_sub_varian
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    success: function (data) {
                        $('#varian').html(data);
                        alert('nama varian berhasil ditambahkan');
                    }
                });
       }
       
    }

    function save_tambah_sub_varian(){
       var nama_sub_varian = $('#sub_varian_nama').val();
       var label_varian = $('#label_varian').val();
       var label_sub_varian = $('#label_sub_varian').val();

       if(nama_sub_varian == '' || label_varian == '' || label_sub_varian == ''){
           alert('Data belum lengkap,mohon diperiksa kembali!');
       }else{
        var token = '{{ csrf_token() }}';
        var id_produk = '{{$produk->id_produk}}';
                var my_url = "{{url('/save_tambah_sub_varian')}}";
                var formData = {
                    '_token': token,
                    'id_produk': id_produk,
                    'nama_sub_varian': nama_sub_varian,
                    'label_varian': label_varian,
                    'label_sub_varian': label_sub_varian
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    success: function (data) {
                        $('#varian').html(data);
                        alert('nama sub varian berhasil ditambahkan!');
                    }
                });
       }
    }

    function hapus_varian(id){
        konfirmasi = confirm('Apakah kamu yakin untuk menghapus sub varian ini?');
        if(konfirmasi == true){
            var token = '{{ csrf_token() }}';
            var id_produk = '{{$produk->id_produk}}';
                var my_url = "{{url('/hapus_varian_produk')}}";
                var formData = {
                    '_token': token,
                    'id_varian': id,
                    'id_produk': id_produk
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    success: function (data) {
                        $('#varian').html(data);
                        alert('varian berhasil dihapus');
                    }
                });
        }
       
    }

    function hapus_sub_varian(id){
        konfirmasi = confirm('Apakah kamu yakin untuk menghapus sub varian ini?');
        if(konfirmasi == true){
            var token = '{{ csrf_token() }}';
            var id_produk = '{{$produk->id_produk}}';
                var my_url = "{{url('/hapus_sub_varian_produk')}}";
                var formData = {
                    '_token': token,
                    'id_sub_varian': id,
                    'id_produk': id_produk
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    success: function (data) {
                        $('#varian').html(data);
                        alert('Sub varian berhasil dihapus');
                    }
                });
        }
        
    }

    function hapus_gambar(id_gambar){
        var jumlah_gambar = document.getElementsByClassName('data_gambar').length;
        if(jumlah_gambar <= 1){
            alert('maaf gambar tidak bisa dihapus ');
        }else{
            konfirmasi = confirm('Kamu yakin menghapus gambar ini?');
        if(konfirmasi == true){
            var token = '{{ csrf_token() }}';
            var id_produk = '{{$produk->id_produk}}';
                var my_url = "{{url('/hapus_gambar_produk')}}";
                var formData = {
                    '_token': token,
                    'id_gambar': id_gambar,
                    'id_produk': id_produk
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    success: function (data) {
                        alert('Gambar berhasil dihapus');
                        $('#gambar_produk').html(data);
                    }
                });
        }
        }
       
    }

</script>


@endsection