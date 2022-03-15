@extends('layouts.admin_template')

@section('content')
<h2 class="text-center">Data Kategori Produk</h2>
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambah_kategori">Tambah Kategori</button>
<table id="coba-table" class="table table-striped table-bordered table-hover table-sm nowarp">
  <thead>
    <tr style="color: white; background-color: #78909c" align="center" >
      <th>No</th>
      <th>Nama Kategori</th>
      <th>Gambar</th>
      <th>Status</th>
      <th>Opsi</th>
    </tr>
  </thead>
</table>
<!-- Modal Tambah Kategori -->
<div class="modal fade" id="tambah_kategori" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="{{url('tambah_kategori')}}" method="post" enctype="multipart/form-data">
       {{csrf_field()}}
        <div class="modal-header">
          <h4 class="modal-title" id="tambahModalLabel">Tambah Kategori</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="formTambahSlider" class="modal-body">
        <div class="mb-3">
          <label for="nama" class="form-label">Nama Kategori</label>
          <input type="text" name="nama" class="form-control" id="nama" required>
        </div>
        <div class="mb-3">
          <label for="gambar" class="form-label">Gambar</label>
          <input type="file" name="gambar_kategori" id="gambar" class="form-control" required>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Edit Kategori -->
<div class="modal fade" id="edit_kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="{{url('edit_kategori_save')}}" method="post" enctype="multipart/form-data">
       {{csrf_field()}}
        <div class="modal-header">
          <h4 class="modal-title" id="editModalLabel">Edit Kategori</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="data_edit">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- <textarea id="konten" class="form-control" name="konten" rows="10" cols="50"></textarea>
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<script>
   var konten = document.getElementById("konten");
     CKEDITOR.replace(konten,{
     language:'en-gb'
   });
   CKEDITOR.config.allowedContent = true;
</script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#coba-table').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ordering: true,
      ajax: "{{url('/Admin/data_kategori')}}",
      columns: [
        {
           render: function (data, type, row, meta) {
             return meta.row + meta.settings._iDisplayStart + 1;
           },
        },
        {
            render: function (data, type, row, meta) {
             return '<h6>'+ row.nama_kategori +'</h6>'
           }
        },
        {
           data:'gambar',
           render: function(data,row){
             return "<img "+ 'width="100px"' +" src={{ URL::to('/')}}/gambar_kategori/" + data + " >"
           }
        },
        {
          data:'status',
          render: function(data){
            if(data == 1){
              return 'Aktif'
            }else{
              return 'Tidak Aktif'
            }
          }
        },
        {
            data:'action'
        }
      ],
    });
  });

  function hapus_kategori(id_kategori){
    tanya = confirm("jika kategori dihapus,seluruh produk yang ada di kategori ikut terhapus.Anda yakin menghapus kategori ?");
            if (tanya == true) {
                var token = '{{ csrf_token() }}';
                var my_url = "{{url('/hapus_kategori')}}";
                var formData = {
                    '_token': token,
                    'id_kategori' : id_kategori
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    //dataType: 'json',
                    success: function (resp) {
                        alert(' kategori produk berhasil dihapus!');
                        location.reload();
                    },
                    error: function (resp) {
                        console.log(resp);
                    }
                });
            } else {
                return false;
            }
  }

  function ubah_kategori(id_kategori){
    var token = '{{ csrf_token() }}';
    var my_url = "{{url('/ubah_kategori')}}";
    var formData = {
          '_token': token,
          'id_kategori' : id_kategori
        };
        $.ajax({
          method: 'POST',
          url: my_url,
          data: formData,
          success: function (resp) {
            $('#data_edit').html(resp);
          },
          error: function (resp) {
            console.log(resp);
          }
        });                              
  }
</script>
@endsection