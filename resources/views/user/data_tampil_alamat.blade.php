<h2 class="mb-4">Daftar Alamat</h2>

<button onclick="tambah_alamat()" class="btn btn-success mb-3">Tambah Alamat</button>
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama Penerima</th>
      <th scope="col">No.Telp</th>
      <th scope="col">Alamat Lengkap</th>
      <th scope="col">Opsi</th>
    </tr>
  </thead>
  <tbody>
    @if(count($daftar_alamat) != 0)
      @foreach($daftar_alamat as $da)
      <tr>
        <th scope="row">{{$da->keterangan}}</th>
        <td>{{$da->nama_penerima}}</td>
        <td>{{$da->no_hp}}</td>
        <td>
          {{$da->alamat_lengkap}},{{$da->nama_kec}},{{$da->nama_kab}},{{$da->nama_prov}} {{$da->kode_pos}}
        </td>
        <td>
            <button onclick="hapus_alamat('{{$da->id_alamat}}')" class="btn btn-danger">Hapus</button>
        </td>
    </tr>
      @endforeach
    @else
    @endif
  </tbody>
</table>
</div>