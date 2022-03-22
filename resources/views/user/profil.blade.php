    @extends('layouts.app')
    <div class="container my-5">
        <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h2>Profil Saya</h2>
                <p>Kelola informasi profil anda untuk mengontrol,melindungi dan mengamankan akun</p>
                <form method="post" action="{{url('UbahProfil')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                  <div class="form-group">
                    <label >Ubah Foto Profile</label>
                    <input type="file" accept="image/*" class="form-control-file" name="gambar">
                  </div>
                  <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" value="{{$profil->name}}" name="nama" disabled>
                  </div>
                  <div class="form-group">
                      <label>Nama Depan</label>
                      <input type="text" class="form-control" value="{{$profil->nama_depan}}" name="nama_depan" required>
                  </div>
                  <div class="form-group">
                      <label>Nama Belakang</label>
                      <input type="text" class="form-control" value="{{$profil->nama_belakang}}" name="nama_belakang" required>
                  </div>
                  <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" value="{{$profil->email}}" disabled>
                  </div>
                  <div class="form-group">
                      <label>Nomor Telepon</label>
                      <input type="number" name="telp" class="form-control" value="{{$profil->telp}}" required>
                  </div>
                  <div class="form-group">
                    <label>Jenis Kelamin</label>
                      <div class="form-check">
                        <input name="kelamin" class="form-check-input" type="radio" name="exampleRadios" id="laki-laki" value="laki-laki"
                        @if($profil->kelamin == 'laki-laki')
                        checked
                        @endif
                        >
                        <label class="form-check-label" for="laki-laki">
                         Laki laki
                        </label>
                    </div>
                     <div class="form-check">
                        <input name="kelamin" class="form-check-input" type="radio" name="exampleRadios" id="perempuan" value="Perempuan"
                         @if($profil->kelamin == 'Perempuan')
                            checked
                        @endif
                        >
                        <label class="form-check-label" for="perempuan">
                         Perempuan
                        </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Tanggal Lahir</label>
                      <input type="date" class="form-control" name="date" value="{{$profil->tanggal_lahir}}" required >
                  </div>
                   <input type="submit" value="Simpan Perubahan" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>

