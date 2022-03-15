@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<div class="container">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('gambar_slider/'.$home_slider[0]->gambar)}}" style="height:60vh;" class="d-block w-100" alt="fgfhfsuh">
            </div>
            <div class="carousel-item ">
                <img src="{{asset('gambar_slider/'.$home_slider[1]->gambar)}}" style="height:60vh;" class="d-block w-100" alt="gambar 2">
            </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    </div>
    
    <div class="judul my-3"><h3>KATEGORI</h3></div>
    <div class="row">
    @foreach($kategori as $k)
    <div class="col-md-2">
        <div class="card mb-3">
            <div class="card-body">
                <a href="{{url('kategori_produk/'.$k->nama_kategori.'/'.$k->id_kategori)}}"><img class="img-fluid" style="display:block;margin:auto;width:100px;" src="{{asset('gambar_kategori/'.$k->gambar)}}" alt="$k->nama_kategori"></a> 
            </div>
        </div>
    </div>
    @endforeach
    </div> 
</div>

@endsection