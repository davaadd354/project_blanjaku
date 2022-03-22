<h2 class="text-center">Tambah Alamat</h2>

<form id="form_tambah_alamat">
    <div class="form-group">
        <label for="keterangan">Simpan Sebagai</label>
        <input type="text" id="keterangan" name="keterangan" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="nama_penerima">Nama Penerima</label>
        <input type="text" id="nama_penerima" name="nama_penerima" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="no_hp">Nomor Handphone</label>
        <input type="number" id="no_hp" name="no_hp" class="form-control" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="data_provinsi">Provinsi</label>
        <select name="provinsi_id" id="data_provinsi" onChange="tampilKabupaten(this.value)" required
            class="form-control custom-select">
            <option value="">Pilih Provinsi</option>
            @foreach($provinsi as $prov)
                <option value="{{$prov->id}}">{{$prov->nama}}</option>
            @endforeach
        </select>
    </div>
    <div id="kab" class="form-group">
        <label class="form-label" for="data_kabupaten">Kabupaten</label>
            <select name="kabupaten_id" id="data_kabupaten" onChange="tampilKecamatan(this.value)" required
                class="form-control custom-select">
                <option value="">Pilih Kabupaten</option>
            </select>
    </div>
    <div id="kec" class="form-group">
        <label class="form-label" for="data_kecamatan">kecamatan</label>
            <select name="kecamatan_id" id="data_kecamatan" required
                class="form-control custom-select">
                <option value="">Pilih Kecamatan</option>
            </select>
    </div>
    <div class="form-group">
        <label for="kode_pos">Kode Pos</label>
        <input type="number" id="kode_pos" name="kode_pos" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="alamat_lengkap">Alamat Lengkap</label>
        <textarea name="alamat_lengkap" id="alamat_lengkap" cols="15" rows="5" class="form-control" required></textarea>
    </div>
    <button class="btn btn-success" type="submit">Submit</button>
</form>

<script>
    function tampilKabupaten(id_provinsi){
        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/data_tampil_kabupaten')}}";
        var formData = {
            '_token': token,
            'id_provinsi': id_provinsi
        };
        $.ajax({
            method: 'POST',
            url: my_url,
            data: formData,
            success: function (data) {
                //$('#halaman_akun').html(data);
                var coba = '<option value="">Pilih Kabupaten</option>';
                for(var i = 0;i <= data.length - 1 ; i++){
                    coba += '<option value="'+ data[i].id +'">'+ data[i].nama +'</option>';
                }
                $('#data_kabupaten').html(coba);   
        }
    });   
    }

    function tampilKecamatan(id_kabupaten){
        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/data_tampil_kecamatan')}}";
        var formData = {
            '_token': token,
            'id_kabupaten': id_kabupaten
        };
        $.ajax({
            method: 'POST',
            url: my_url,
            data: formData,
            success: function (data) {
                //$('#halaman_akun').html(data);
                var coba = '<option value="">Pilih Kecamatan</option>';
                for(var i = 0;i <= data.length - 1 ; i++){
                    coba += '<option value="'+ data[i].id +'">'+ data[i].nama +'</option>';
                }
                $('#data_kecamatan').html(coba);   
        }
    });   
    }

    $('#form_tambah_alamat').on('submit',function(e){
        e.preventDefault();
        
        let keterangan = $('#keterangan').val();
        let nama_penerima = $('#nama_penerima').val();
        let no_hp = $('#no_hp').val();
        let provinsi = $('#data_provinsi').val();
        let kabupaten = $('#data_kabupaten').val();
        let kecamatan = $('#data_kecamatan').val();
        let kode_pos = $('#kode_pos').val();
        let alamat = $('#alamat_lengkap').val();

        var token = '{{ csrf_token() }}';
        var my_url = "{{url('/save_tambah_alamat')}}";
        var formData = {
            '_token': token,
            'keterangan': keterangan,
            'nama_penerima': nama_penerima,
            'no_hp': no_hp,
            'provinsi': provinsi,
            'kabupaten': kabupaten,
            'kecamatan': kecamatan,
            'kode_pos': kode_pos,
            'alamat': alamat 
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

    });
</script>