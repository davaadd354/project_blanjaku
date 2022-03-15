@foreach($gambar as $g)
    <img src="{{asset('gambar_produk/'.$g->nama_gambar)}}" alt="{{$g->nama_gambar}}" width="100px" class="mb-2 mr-2">
    <img onclick="hapus_gambar('{{$g->id_gambar}}')" src="https://img.icons8.com/material-rounded/24/fa314a/filled-trash.png"/>
@endforeach