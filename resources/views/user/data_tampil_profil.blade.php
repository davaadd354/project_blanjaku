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