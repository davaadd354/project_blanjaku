@extends('layouts.app')

@section('content')
<h2 class="text-center">Checkout Pesanan</h2>
<div class="container">
    <h2>Informasi Pengiriman</h2>
    <form action="{{url('buat_pesanan')}}" method="post" >
    {{csrf_field()}}
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
                                <select id="kurir" onChange="tampiLayanan(this.value)" name="kurir"
                                class="form-control">
                                    <option value="" class="warna">--Pilih Ekspedisi--</option>
                                    @foreach($ekspedisi as $ex)
                                        <option value="{{$ex->rajaongkir_name}}">{{$ex->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                            <select id="layanan_kurir" onchange="totalHarga(this.value)" name="layanan_kurir"
                                class="form-control">
                                    <option value="" class="warna">--Pilih Layanan--</option>
                                </select>
                            <input type="text" name="nama_layanan_kurir" id="nama_layanan_kurir" hidden>
                            </div>
                        </div>
                    <label class="form-label"><b>Metode Pembayaran</b></label>
                    <div class="row">
                    <div class="col">
                                <select id="pembayaran" name="pembayaran"
                                class="form-control">
                                    <option value="" class="warna">--Pilih Metode Pembayaran--</option>
                                    @foreach($pembayaran as $p)
                                        <option value="{{$p->id}}">{{$p->pembayaran}}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <label class="form-label"><b>Dropship</b></label>
                    <div class="row">
                        <div class="col">
                            <span  id="non_dropship" onclick="tidakDropship()" class="btn btn-outline-success" hidden>Tidak Dropship</span>
                            <span  id="non_dropship_check"  class="btn btn-success">
                                <img width="20px" src="https://img.icons8.com/ios-glyphs/30/ffffff/check-all.png"/>Tidak Dropship
                            </span>
                            <span  id="dropship" onclick="dropship()" class="btn btn-outline-success">Dropship</span>
                            <span  id="dropship_check" class="btn btn-success" hidden>
                                <img width="20px" src="https://img.icons8.com/ios-glyphs/30/ffffff/check-all.png"/>Dropship
                            </span>
                        </div>   
                    </div>
                    <div id="dropshipper" hidden>
                        <div class="row">
                            <div class="col-6 mt-2">
                                <input type="text" id="nama_dropship" name="nama_dropship" class="form-control" placeholder="Nama Dropshipper">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mt-2">
                                <input type="number" id="telp_dropship" name="telp_dropship" class="form-control" placeholder="Nomor Telepon Dropshipper">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mt-2 mb-2">
                                <textarea name="alamat_droship" id="alamat_dropship" cols="10" rows="5" class="form-control" placeholder="Alamat Dropshipper"></textarea>
                            </div>
                        </div>
                    </div>
                    <label class="form-label"><b>Daftar Produk</b></label>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Gambar</th>
                                    <th scope="col">Harga Satuan</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Subtotal Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_pesanan = 0; ?>
                                    @foreach($keranjang as $k)
                                    <tr>
                                        <td>{{$k->nama_produk}}</td>
                                        <td><img width="100px" src="{{asset('gambar_produk/'.$k->nama_gambar)}}" alt="{{$k->nama_produk}}"></td>
                                        <td>{{$k->jumlah}}</td>
                                        <td>{{"Rp " . number_format($k->harga_produk,2,',','.')}}</td>
                                        <td>{{"Rp " . number_format($k->harga_total,2,',','.')}}</td>
                                    </tr>
                                    <input checked type="checkbox" name="cart[]" value="{{$k->id_cart}}" class="check_box" hidden>
                                    <?php $total_pesanan += $k->harga_total ?>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Ongkos Kirim
                                        </td>
                                        <input type="number" value="0" id="input_ongkir" name="input_ongkir" hidden>
                                        <td colspan="2" class="text-center" id="ongkir">
                                             Rp.0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center" id="voucher">
                                            Voucher
                                        </td>
                                        <td colspan="2" class="text-center">
                                           - Rp.0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Berat Total
                                        </td>
                                        <input type="number" value="{{$berat}}" id="berat_total" name="berat_total" hidden>
                                        <td colspan="2" class="text-center">
                                           {{number_format($berat)}} kg
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Total Pesanan
                                        </td>
                                        <input type="number" value="{{$total_pesanan}}" id="input_total_pesanan" name="input_total_pesanan" hidden>
                                        <td colspan="2" class="text-center" id="total_pesanan">
                                        {{"Rp " . number_format($total_pesanan,2,',','.')}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-2 offset-10">
                                <button class="btn btn-success" type="submit" id="buat_pesanan" hidden>Buat Pesanan</button>
                                <span class="btn btn-success" onclick="cekData()">Buat Pesanan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<script>
     function rupiah(nominal){
            var	reverse = nominal.toString().split('').reverse().join(''),
            ribuan 	= reverse.match(/\d{1,3}/g);
            ribuan	= ribuan.join('.').split('').reverse().join('');

            return ribuan;
    }
    function tampilAlamat(id_alamat){
        let opsi = '<option value="">Pilih Layanan</option>'
        $('#layanan_kurir').html(opsi);
        document.getElementById('ongkir').innerHTML = 'Rp.0'
        document.getElementById('total_pesanan').innerHTML = 'Rp ' + rupiah(parseInt('{{$total_pesanan}}')) + ',00'
        document.getElementById('input_ongkir').value = 0
        document.getElementById('input_total_pesanan').value = parseInt('{{$total_pesanan}}')
        document.getElementById('nama_layanan_kurir').value = ""

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
        //refresh dulu bagian ongkos kirim dan total pesanan
        document.getElementById('ongkir').innerHTML = 'Rp.0'
        document.getElementById('total_pesanan').innerHTML = 'Rp ' + rupiah(parseInt('{{$total_pesanan}}')) + ',00'
        document.getElementById('input_ongkir').value = 0
        document.getElementById('input_total_pesanan').value = parseInt('{{$total_pesanan}}')
        
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
                            opsi += '<option value="">Pilih Layanan</option>'
                            if(data == 'gagal'){
                                console.log(data);
                                $('#layanan_kurir').html(opsi);
                            }else{
                                $.each(data , function(index,val){
                                    opsi += '<option value="'+val.cost[0].value+'">'+val.service+' ('+val.description+') '+'</option>'
                                });
                                $('#layanan_kurir').html(opsi);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
            }
        }else if(alamat == ''){
            alert('mohon lengkapi data alamat terlebih dahulu!');
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
                    opsi += '<option value="">Pilih Layanan</option>'
                    if(data == 'gagal'){
                        console.log(data);
                        $('#layanan_kurir').html(opsi);
                    }else{
                        $.each(data , function(index,val){
                            opsi += '<option value="'+val.cost[0].value+'" id="'+val.cost[0].value+'">'+val.service+' ('+val.description+') '+'</option>'
                        });
                        $('#layanan_kurir').html(opsi);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        
    }

    function totalHarga(ongkir){
        let data_layanan = document.getElementById(ongkir).innerHTML
        if(ongkir == ''){
            document.getElementById('ongkir').innerHTML = 'Rp.0'
            document.getElementById('input_ongkir').value = 0
            document.getElementById('total_pesanan').innerHTML = 'Rp ' + rupiah(parseInt('{{$total_pesanan}}')) + ',00'
            document.getElementById('input_total_pesanan').value = parseInt('{{$total_pesanan}}')
            document.getElementById('nama_layanan_kurir').value = ""
        }else{
            let ongkos_kirim = document.getElementById('ongkir').innerHTML = 'Rp '+rupiah(ongkir)+',00'
            let input_ongkir = document.getElementById('input_ongkir').value = parseInt(ongkir)
            let total_pesanan = parseInt('{{$total_pesanan}}') + parseInt(ongkir);
            let ubah_total_pesanan = document.getElementById('total_pesanan').innerHTML = 'Rp ' + rupiah(total_pesanan) + ',00'
            let ubah_input_total_pesanan = document.getElementById('input_total_pesanan').value = total_pesanan
            let nama_layanan_kurir = document.getElementById('nama_layanan_kurir').value = data_layanan
            
        }
    }

    function dropship(){
        let tampil_form = document.getElementById('dropshipper').removeAttribute('hidden');

        document.getElementById('dropship').setAttribute('hidden',true);
        document.getElementById('dropship_check').removeAttribute('hidden');
      
        document.getElementById('non_dropship').removeAttribute('hidden');
        document.getElementById('non_dropship_check').setAttribute('hidden',true);
    }

    function tidakDropship(){
        let hidden_form = document.getElementById('dropshipper').setAttribute('hidden',true);
        
        document.getElementById('non_dropship').setAttribute('hidden',true);
        document.getElementById('non_dropship_check').removeAttribute('hidden');
      
        document.getElementById('dropship').removeAttribute('hidden');
        document.getElementById('dropship_check').setAttribute('hidden',true);
    }

    function cekData(){
        let alamat = $('#alamat').val();
        let kurir = $('#kurir').val();
        let layanan_kurir = $('#layanan_kurir').val();
        let nama_dropship = $('#nama_dropship').val();
        let telp_dropship = $('#telp_dropship').val();
        let alamat_dropship = $('#alamat_dropship').val();
        let keterangan = $('#keterangan').val();
            let nama_penerima = $('#nama_penerima').val();
            let no_hp = $('#no_hp').val();
            let provinsi = $('#data_provinsi').val();
            let kabupaten = $('#data_kabupaten').val();
            let kecamatan = $('#data_kecamatan').val();
            let kode_pos = $('#kode_pos').val();
            let alamat_lengkap = $('#alamat_lengkap').val();
            let id_alamat_pengiriman = 0;
        if(alamat == 'tambah'){
            if(keterangan == '' || nama_penerima == '' || no_hp == '' || provinsi == '' || kabupaten == '' || kecamatan == '' || kode_pos == '' || alamat_lengkap == ''){
                alert('mohon lengkapi data alamat terlebih dahulu!');
                //$('#layanan_kurir').hide();
                return false;
            }else{
                var token = '{{ csrf_token() }}';
                var my_url = "{{url('/save_tambah_alamat_pengiriman')}}";
                var formData = {
                        '_token': token,
                        'keterangan' : keterangan,
                        'nama_penerima' : nama_penerima,
                        'no_hp' : no_hp,
                        'provinsi' : provinsi,
                        'kabupaten' : kabupaten,
                        'kecamatan' : kecamatan,
                        'kode_pos' : kode_pos,
                        'alamat_lengkap' : alamat_lengkap
                };
                $.ajax({
                    method : 'post',
                    url : my_url,
                    data : formData,

                    success:function(resp){
                        //id_alamat_pengiriman = parseInt(resp);
                        document.getElementById('buat_pesanan').click();
                    },
                    error:function(resp){
                        console.log(resp)
                        return false
                    }
                });
            }
        }else if(alamat == ''){
            alert('mohon lengkapi data alamat terlebih dahulu!');
            return false
        }else{
            id_alamat_pengiriman = $('#id_alamat_pengiriman').val();
        }

        if(kurir == ''){
            alert('mohon isi data kurir pengiriman');
            return false;
        }
        if(layanan_kurir == ''){
            alert('mohon isi layanan pemgiriman');
            return false;
        }
        if(pembayaran == ''){
            alert('mohon isi jenis pembayaran');
            return false;
        }
        let cek_dropship = document.getElementById('dropship').getAttribute('hidden');
        if(cek_dropship){
            if(nama_dropship == ''){
                alert('mohon isi nama dropshipper')
                return false
            }
            if(telp_dropship == ''){
                alert('mohon isi telepon dropshipper')
                return false
            }
            if(alamat_dropship == ''){
                alert('mohon isi alamat dropshipper')
                return false
            }else{
                document.getElementById('buat_pesanan').click();
            }
        }else{
            document.getElementById('buat_pesanan').click();
        }
       
        
         
    }

</script>
<!-- <script>
   function buatPesanan(){
       alert('berhasil');
        let alamat = $('#alamat').val();
        let kurir = $('#kurir').val();
        let layanan_kurir = $('#layanan_kurir').val();
        let nama_dropship = $('#nama_dropship').val();
        let telp_dropship = $('#telp_dropship').val();
        let alamat_dropship = $('#alamat_dropship').val();
        let keterangan = $('#keterangan').val();

            var token = '{{csrf_token()}}'
            var myUrl = "{{url('/buat_pesanan')}}"
            var formData = {
                '_token' : token,
                'id_alamat' : id_alamat_pengiriman,
                'kurir' : kurir,
                'layanan_kurir' : layanan_kurir,
                'nama_dropship' : nama_dropship,
                'telp_dropship' : telp_dropship,
                'alamat_dropship' : alamat_dropship,
                'pembayaran' : pembayaran,
                //'keranjang' : '{{$keranjang}}'
            }

            $.ajax({
                method : 'post',
                url : myUrl,
                data : formData,

                success : function(resp){
                    console.log(resp)
                },
                error : function(resp){
                    console.log(resp)
                })

    }
</script> -->
@endsection