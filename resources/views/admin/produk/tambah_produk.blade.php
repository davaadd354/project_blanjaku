<h1 class="text-center">Tambah Produk</h1>
<form  action="{{url('save_tambah_produk')}}" method="post" enctype="multipart/form-data">
{{csrf_field()}}
<div class="container">
    <div class="card mb-4">
        <div class="card-header"><h4>Nama & Kategori Produk</h4></div>
        <div class="card body px-3">
                <div class="mb-3">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input required type="text" class="form-control" name="nama" id="nama">
                    </div>
                </div>
                <div class="mb-5">
                    <div class="form-group">
                    <label>Kategori</label>
                    <select required class="form-select" name="kategori">
                        <option>Pilih...</option>
                        @foreach($kategori as $k)
                        <option value="{{$k->id_kategori}}">{{$k->nama_kategori}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header"><h4>Harga & Stok Produk</h4></div>
        <div class="card-body px-3">
            <div class="mb-3">
                <div class="form-group">
                    <label for="stok" class="form-label">Stok Barang</label>
                    <input required type="number" class="form-control" name="stok" id="stok">
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="min_order" class="form-label">Minimal Order</label>
                    <input required type="number" class="form-control" name="min_order" id="min_order">
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="harga_normal" class="form-label">Harga Normal</label>
                    <input required type="number" class="form-control" name="harga_normal" id="harga_normal">
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="harga_coret" class="form-label">Harga Diskon</label>
                    <input required type="number" class="form-control" name="harga_coret" id="harga_coret">
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
                    <input required type="number" class="form-control" name="berat" id="berat">
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" class="form-control" name="deskripsi" rows="10" cols="50"></textarea>
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
                <div class="row" id="form_gambar_detail">
                    <div class="col-4">
                        <div class="form-group">
                            <div class="custom-file">
                                <input required type="file" class="file_upload" id="file" name="gambar[]">
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
        <div class="card-body">
            <p class="text-center">Untuk membuat varian produk, silahkan simpan dulu produk ini setelah itu edit produk yang telah disimpan.</p>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Simpan</button>
    <a href="#" class="btn btn-danger">Batal</a>
</div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
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
                <label class="form-label">&nbsp;</label>
                <div class="custom-file">
                    <input required type="file" class="file_upload" id="file" name="gambar[]">
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

</script>