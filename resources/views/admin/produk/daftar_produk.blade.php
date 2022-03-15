@extends('layouts.admin_template')

@section('content')

<div id="product">
<h2 class="text-center">Hello Produk</h2>
<button class="btn btn-success" onclick="tambah_produk()" >Tambah Produk</button>
<table id="table_produk" class="table table-striped table-bordered table-hover table-sm nowarp">
  <thead>
    <tr style="color: white; background-color: #78909c" align="center" >
      <th>No</th>
      <th>Nama Produk</th>
      <th>Gambar</th>
      <th>stok</th>
      <th>Opsi</th>
    </tr>
  </thead>
</table>
</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#table_produk').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ordering: true,
      ajax: "{{url('/tampil_data_produk')}}",
      columns: [
        {
           render: function (data, type, row, meta) {
             return meta.row + meta.settings._iDisplayStart + 1;
           },
        },
        {
            render: function (data, type, row, meta) {
             return '<h6>'+ row.nama_produk +'</h6>'
           }
        },
        {
           data:'gambar'
        },
        {
          data:'stok'
        },
        {
            data:'action'
        }
      ],
    });
  });


    function tambah_produk(){
                var token = '{{ csrf_token() }}';
                var my_url = "{{url('/Admin/tambah_produk')}}";
                var formData = {
                    '_token': token
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    //dataType: 'json',
                    success: function (resp) {
                       $('#product').html(resp);
                    },
                    error: function (resp) {
                        console.log(resp);
                    }
                });
    }

    function hapus_produk(id){
        alert(id);
    }

    function ubah_produk(id_produk){
        var token = '{{ csrf_token() }}';
    var my_url = "{{url('/edit_data_produk')}}";
    var formData = {
          '_token': token,
          'id_produk' : id_produk
        };
        $.ajax({
          method: 'POST',
          url: my_url,
          data: formData,
          success: function (resp) {
            $('#product').html(resp);
          },
          error: function (resp) {
            console.log(resp);
          }
        });                              
  }

</script>

@endsection