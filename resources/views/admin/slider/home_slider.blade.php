@extends('layouts.admin_template')

@section('content')
<!-- DataTables -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap.min.css"> -->
<h2 class="text-center">Data Slider Promosi</h2>
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambah_slider">Tambah Slider</button>
<table id="coba-table" class="table table-striped table-bordered table-hover table-sm nowarp">
  <thead>
    <tr style="color: white; background-color: #78909c" align="center" >
      <th>No</th>
      <th>Judul Gambar</th>
      <th>Gambar</th>
      <th>Link Promosi</th>
      <th>Status</th>
      <th>Opsi</th>
    </tr>
  </thead>
</table>
<!-- Modal Tambah Slider -->
<div class="modal fade" id="tambah_slider" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="{{url('tambah_slider')}}" method="post" enctype="multipart/form-data">
       {{csrf_field()}}
        <div class="modal-header">
          <h4 class="modal-title" id="tambahModalLabel">Tambah Slider</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="formTambahSlider" class="modal-body">
        <div class="mb-3">
          <label for="judul" class="form-label">Judul Slider</label>
          <input type="text" name="judul" class="form-control" id="judul" required>
        </div>
        <div class="mb-3">
          <label for="link_slider" class="form-label">Link Promosi Slider</label>
          <input type="text" name="link_slider" class="form-control" id="link_slider" required>
        </div>
        <div class="mb-3">
          <label for="gambar" class="form-label">Gambar Slider</label>
          <input type="file" name="gambar" id="gambar" class="form-control" required>
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
<!-- Modal Edit Slider -->
<div class="modal fade" id="edit_slider" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="{{url('edit_slider_save')}}" method="post" enctype="multipart/form-data">
       {{csrf_field()}}
        <div class="modal-header">
          <h4 class="modal-title" id="editModalLabel">Edit Slider</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="formEditSlider" class="modal-body">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script> -->
<script type="text/javascript">
  $(document).ready(function () {
    $('#coba-table').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ordering: true,
      ajax: "{{url('/Admin/data_slider')}}",
      columns: [
        {
           render: function (data, type, row, meta) {
             return meta.row + meta.settings._iDisplayStart + 1;
           },
        },
        {
            render: function (data, type, row, meta) {
             return '<h6>'+ row.judul +'</h6>'
           }
        },
        {
           data:'gambar',
           render: function(data,row){
             return "<img "+ 'width="100px"' +" src={{ URL::to('/')}}/gambar_slider/" + data + " >"
           }
        },
        {
           data: 'link'
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

  function hapus_slider(id_slider){
    tanya = confirm("Anda yakin menghapus Slider ?");
            if (tanya == true) {
                var token = '{{ csrf_token() }}';
                var my_url = "{{url('/hapus_slider')}}";
                var formData = {
                    '_token': token,
                    'id_slider' : id_slider
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    //dataType: 'json',
                    success: function (resp) {
                        alert(' Slider berhasil dihapus!');
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

  function ubah_slider(id_slider){
    var token = '{{ csrf_token() }}';
    var my_url = "{{url('/ubah_slider')}}";
    var formData = {
          '_token': token,
          'id_slider' : id_slider
        };
        $.ajax({
          method: 'POST',
          url: my_url,
          data: formData,
          success: function (resp) {
          $('#formEditSlider').html(resp);
          },
          error: function (resp) {
            console.log(resp);
          }
        });                              
  }
</script>
@endsection