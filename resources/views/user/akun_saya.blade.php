@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3">
            <h4>
                @if(isset($user_data->foto_profil))
                    @if($user_data->foto_profil != null)
                    <img src="{{asset('gambar_profil/'.$user_data->foto_profil)}}" width="40px" alt="gambar profil">
                    @endif
                @else
                    <img width="40px" src="https://img.icons8.com/external-bearicons-glyph-bearicons/64/000000/external-User-essential-collection-bearicons-glyph-bearicons.png"/>
                @endif
                    {{$user_data->name}}
            </h4>
            <hr>
            <ul style="list-style: none;">
                <li><a onclick="tampil_profil()"><img width="24px" class="my-3" src="https://img.icons8.com/ios-glyphs/30/000000/user--v1.png"/>Profil</a></li>
                <li><a onclick="tampil_alamat()"><img width="24px" class="my-3" src="https://img.icons8.com/ios-glyphs/30/000000/address.png"/>Alamat</a></li>
                <li><a onclick="tampil_notif()"><img width="24px" class="my-3" src="https://img.icons8.com/ios-glyphs/30/000000/appointment-reminders--v1.png"/>Notifikasi</a></li>
                <li><a onclick="tampil_pesanan()"><img width="24px" class="my-3" src="https://img.icons8.com/ios-glyphs/30/000000/purchase-order.png"/>Pesanan Saya</a></li>
                <li><a onclick="tampil_voucher()"><img width="24px" class="my-3" src="https://img.icons8.com/ios-glyphs/30/000000/discount-ticket.png"/>Voucher Saya</a></li>
            </ul>
        </div>
        <div class="col-9">
        <div class="row">
            <div id="halaman_akun" class="col-md-10 offset-md-1">
                <h2>Profil Saya</h2>
                <p>Kelola informasi profil anda untuk mengontrol,melindungi dan mengamankan akun</p>
                
                <form method="post" action="{{url('edit_profil')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                  <div class="form-group">
                    <label >Ubah Foto Profile</label>
                    <input type="file" accept="image/*" class="form-control-file" name="gambar">
                  </div>
                  <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" value="{{$user_data->name}}" name="nama" disabled>
                  </div>
                  <div class="form-group">
                      <label>Nama Depan</label>
                      <input type="text" class="form-control" value="<?php echo isset($user_data->nama_depan)? $user_data->nama_depan : ''; ?>" name="nama_depan" >
                  </div>
                  <div class="form-group">
                      <label>Nama Belakang</label>
                      <input type="text" class="form-control" value="<?php echo isset($user_data->nama_belakang)? $user_data->nama_belakang : ''; ?>" name="nama_belakang" >
                  </div>
                  <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" value="{{$user_data->email}}" disabled>
                  </div>
                  <div class="form-group">
                      <label>Nomor Telepon</label>
                      <input type="number" name="telp" class="form-control" value="<?php echo isset($user_data->nomor_telepon)? $user_data->nomor_telepon : ''; ?>" >
                  </div>
                  <div class="form-group">
                    <label>Jenis Kelamin</label>
                   
                    <div class="form-check">
                        <input name="kelamin" class="form-check-input" type="radio"  name="exampleRadios" id="laki-laki" <?php echo $user_data->jenis_kelamin == 'laki-laki'? 'checked' : ''; ?> value="laki-laki">
                        <label class="form-check-label" for="laki-laki">
                         Laki laki
                        </label>
                    </div>
                     <div class="form-check">
                        <input  name="kelamin" class="form-check-input" type="radio" name="exampleRadios" id="perempuan" <?php echo $user_data->jenis_kelamin == 'Perempuan'? 'checked' : ''; ?> value="Perempuan">
                        <label class="form-check-label" for="perempuan">
                         Perempuan 
                        </label>
                    </div>
                   
                  </div>
                  <div class="form-group">
                    <label>Tanggal Lahir</label>
                      <input type="date" class="form-control" name="date" value="<?php echo isset($user_data->tanggal_lahir)? $user_data->tanggal_lahir : ''; ?>" >
                  </div>
                   <input type="submit" value="Simpan Perubahan" class="btn btn-success">
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
<script>
    function tampil_profil(){
        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/data_tampil_profil')}}";
        var formData = {
            '_token': token
        };
        $.ajax({
            method: 'POST',
            url: my_url,
            data: formData,
            success: function (data) {
                $('#halaman_akun').html(data);
                //console.log(data);
        }
    });
 
    }

    function tampil_alamat(){
        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/data_tampil_alamat')}}";
        var formData = {
            '_token': token
        };
        $.ajax({
            method: 'POST',
            url: my_url,
            data: formData,
            success: function (data) {
                $('#halaman_akun').html(data);
                //console.log(data);
        }
    });
    }

    function tampil_notif(){
        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/data_tampil_notif')}}";
        var formData = {
            '_token': token
        };
        $.ajax({
            method: 'POST',
            url: my_url,
            data: formData,
            success: function (data) {
                //$('#halaman_akun').html(data);
                console.log(data);
        }
    });
    }

    function tampil_pesanan(){
        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/data_tampil_pesanan')}}";
        var formData = {
            '_token': token
        };
        $.ajax({
            method: 'POST',
            url: my_url,
            data: formData,
            success: function (data) {
                //$('#halaman_akun').html(data);
                console.log(data);
        }
    });
    }

    function tampil_voucher(){
        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/data_tampil_voucher')}}";
        var formData = {
            '_token': token
        };
        $.ajax({
            method: 'POST',
            url: my_url,
            data: formData,
            success: function (data) {
                //$('#halaman_akun').html(data);
                console.log(data);
        }
    });
    }

    function tambah_alamat(){
        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/tambah_alamat_user')}}";
        var formData = {
            '_token': token
        };
        $.ajax({
            method: 'POST',
            url: my_url,
            data: formData,
            success: function (data) {
                $('#halaman_akun').html(data);
                console.log(data);
        }
    });
    }
</script>
@endsection