@if(!empty($alamat))
<div class="container">
<div class="table-responsive">
<table class="table table-stripped">
  <tbody>
    <input type="number" id="id_alamat_pengiriman" hidden value="{{$alamat->id_alamat}}">
    <input type="number" id="destinasi_id" hidden value="{{$alamat->id_kabupaten}}">
    <tr width="30%">
      <th scope="row">Nama Penerima</th>
      <td>:</td>
      <td>{{$alamat->nama_penerima}}</td>
    </tr>
    <tr>
      <th scope="row">No HP</th>
      <td>:</td>
      <td>{{$alamat->no_hp}}</td>
    </tr>
    <tr>
      <th scope="row">Alamat Lengkap</th>
      <td>:</td>
      <td>
          <p>
              {{$alamat->alamat_lengkap}}, {{$alamat->kecamatan}}, {{$alamat->kabupaten}}, {{$alamat->provinsi}}  {{$alamat->kode_pos}}
          </p>
      </td>
    </tr>
  </tbody>
</table>
</div>
</div>
@endif