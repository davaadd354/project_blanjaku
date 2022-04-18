@extends('layouts.app')

@section('content')
<h2 class="text-center">Checkout Pesanan</h2>
<div class="container">
    <h2>Informasi Pengiriman</h2>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                <div class="form-group">
                    <label class="warna form-label"><b>Alamat Pengiriman</b></label>
                        <select id="alamat" onChange="tampilAlamat(this.value)" required name="alamat"
                            class="form-control">
                            <option value="" class="warna">--Pilih alamat--</option>
                            <option value="tambah">Tambah Alamat Baru +</option>
                            @foreach($data_alamat as $da)
                            <option value="{{$da->id_alamat}}" >{{$da->keterangan}}-{{$da->nama_penerima}}( {{$da->kecamatan}},{{$da->kabupaten}} )</option>
                            @endforeach
                        </select>
                        <div id="tambah_alamat">

                        </div>
                    <label class="form-label"><b>Kurir Pengiriman</b></label>
                        <div class="row">
                            <div class="col">
                                <select id="kurir" onChange="tampiLayanan(this.value)" required name="kurir"
                                class="form-control">
                                    <option value="" class="warna">--Pilih Ekspedisi--</option>
                                    @foreach($ekspedisi as $ex)
                                        <option value="{{$ex->rajaongkir_name}}">{{$ex->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                            <select id="layanan_kurir" required name="layanan_kurir"
                                class="form-control">
                                    <option value="" class="warna">--Pilih Layanan--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function tampilAlamat(id_alamat){
        if(id_alamat == 'tambah'){
            var token = '{{ csrf_token() }}';
            var my_url = "{{url('/tambah_alamat_pengiriman')}}";
            var formData = {
                '_token': token
            };
            $.ajax({
                method: 'POST',
                url: my_url,
                data: formData,
                success: function (data) {
                    
                    $('#tambah_alamat').html(data);
                    
                }
            });
        }else{
            var token = '{{ csrf_token() }}';
            var my_url = "{{url('/tampil_alamat_pengiriman')}}";
            var formData = {
                '_token': token,
                'id_alamat': id_alamat
            };
            $.ajax({
                method: 'POST',
                url: my_url,
                data: formData,
                success: function (data) {
                    $('#tambah_alamat').html(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
            //$('#tambah_alamat').html('');
        }
    }

    function tampiLayanan(kurir){
        var alamat = $('#alamat').val();
        var tag =' <option value="">--Pilih Layanan--</option>';
        if(alamat == 'tambah'){
            let keterangan = $('#keterangan').val();
            let nama_penerima = $('#nama_penerima').val();
            let no_hp = $('#no_hp').val();
            let provinsi = $('#data_provinsi').val();
            let kabupaten = $('#data_kabupaten').val();
            let kecamatan = $('#data_kecamatan').val();
            let kode_pos = $('#kode_pos').val();
            let alamat = $('#alamat_lengkap').val();
            if(keterangan == '' || nama_penerima == '' || no_hp == '' || provinsi == '' || kabupaten == '' || kecamatan == '' || kode_pos == '' || alamat == ''){
                alert('mohon lengkapi data alamat terlebih dahulu!');
                //$('#layanan_kurir').hide();
            }else{
                var token = '{{ csrf_token() }}';
                    var my_url = "{{url('/tampil_layanan_ekspedisi')}}";
                    var formData = {
                        '_token': token,
                        'destinasi': kabupaten,
                        'kurir' : kurir,
                        'berat' : '{{$berat}}'
                    };
                    $.ajax({
                        method: 'POST',
                        url: my_url,
                        data: formData,
                        success: function (data) {
                            var opsi = '';
                            $.each(data , function(index,val){
                                 opsi += '<option value="">'+val.service+'</option>'
                            });
                            $('#layanan_kurir').html(opsi);
                            //console.log(coba);
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
            }
        }else if(alamat == ''){
            alert('mohon lengkapi data alamat terlebih dahulu!');
            //$('#layanan_kurir').hide();
        }else{
            var token = '{{ csrf_token() }}';
            var destinasi = $('#destinasi_id').val();
            var my_url = "{{url('/tampil_layanan_ekspedisi')}}";
            var formData = {
                    '_token': token,
                    'destinasi': destinasi,
                    'kurir' : kurir,
                    'berat' : '{{$berat}}'
            };
            $.ajax({
                method: 'POST',
                url: my_url,
                data: formData,
                success: function (data) {
                    var opsi = '';
                    $.each(data , function(index,val){
                        opsi += '<option value="'+val.cost[0].value+'">'+val.service+'</option>'
                    });
                    $('#layanan_kurir').html(opsi);
                    console.log(opsi);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        
    }
</script>
@endsection