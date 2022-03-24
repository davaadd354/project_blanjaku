<label class="form-label mt-3"><b>Tambah Alamat Pengiriman</b></label>
    <div class="form-group">
        <input placeholder="Simpan Sebagai cth: alamat rumah/alamat kantor" type="text" id="keterangan" name="keterangan" class="form-control" required>
    </div>
    <div class="form-group">
   
        <input placeholder="Nama Penerima" type="text" id="nama_penerima" name="nama_penerima" class="form-control" required>
    </div>
    <div class="form-group">
 
        <input placeholder="Nomor Handphone" type="number" id="no_hp" name="no_hp" class="form-control" required>
    </div>
    <div class="form-group">

        <select name="provinsi_id" id="data_provinsi" onChange="tampilKabupaten(this.value)" required
            class="form-control custom-select">
            <option value="">Pilih Provinsi</option>
            @foreach($provinsi as $prov)
                <option value="{{$prov->id}}">{{$prov->nama}}</option>
            @endforeach
        </select>
    </div>
    <div id="kab" class="form-group">

            <select name="kabupaten_id" id="data_kabupaten" onChange="tampilKecamatan(this.value)" required
                class="form-control custom-select">
                <option value="">Pilih Kabupaten</option>
            </select>
    </div>
    <div id="kec" class="form-group">
            <select name="kecamatan_id" id="data_kecamatan" required
                class="form-control custom-select">
                <option value="">Pilih Kecamatan</option>
            </select>
    </div>
    <div class="form-group">
        <input placeholder="Kode POS" type="number" id="kode_pos" name="kode_pos" class="form-control" required>
    </div>
    <div class="form-group">
        <textarea placeholder="Alamat Lengkap" name="alamat_lengkap" id="alamat_lengkap" cols="15" rows="5" class="form-control" required></textarea>
    </div>
    

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

    // $('#form_tambah_alamat').on('submit',function(e){
    //     e.preventDefault();
        
    //     let keterangan = $('#keterangan').val();
    //     let nama_penerima = $('#nama_penerima').val();
    //     let no_hp = $('#no_hp').val();
    //     let provinsi = $('#data_provinsi').val();
    //     let kabupaten = $('#data_kabupaten').val();
    //     let kecamatan = $('#data_kecamatan').val();
    //     let kode_pos = $('#kode_pos').val();
    //     let alamat = $('#alamat_lengkap').val();

    //     var token = '{{ csrf_token() }}';
    //     var my_url = "{{url('/save_tambah_alamat')}}";
    //     var formData = {
    //         '_token': token,
    //         'keterangan': keterangan,
    //         'nama_penerima': nama_penerima,
    //         'no_hp': no_hp,
    //         'provinsi': provinsi,
    //         'kabupaten': kabupaten,
    //         'kecamatan': kecamatan,
    //         'kode_pos': kode_pos,
    //         'alamat': alamat 
    //     };
    //     $.ajax({
    //         method: 'POST',
    //         url: my_url,
    //         data: formData,
    //         success: function (data) {
    //             $('#halaman_akun').html(data);
    //             //console.log(data);
    //     }
    // });   

    // });
</script>