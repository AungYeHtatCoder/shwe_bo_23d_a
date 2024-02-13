@extends('user_layouts.master')

@section('content')
@include('user_layouts.navbar')
<!-- content -->
<div class="container-fluid py-5 mt-5">
    <!-- carousel -->
    <div id="carouselExampleControls" class="carousel slide border-purple" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($banners as $key => $banner)
            <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                <img src="{{ asset('assets/img/banners/'.$banner->image) }}" class="d-block w-100" alt="Banner {{ $key }}">
            </div>
            @endforeach
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
    <marquee behavior="" direction="">
        {{ $marqueeText->text ?? "" }}
    </marquee>
    <!-- carousel -->

    <!-- 2D 3D -->
    <div class="d-flex justify-content-around my-2">
        <a href="{{ route('user.twod-play-index') }}" class="btn btn-purple text-white d-block w-100 m-3 py-3 d-frame-box rounded-5">
            <h5 class="p-0 m-0">2D</h5>
        </a>
        <a href="{{ url('/user/three-d-play-index') }}" class="btn btn-purple text-white d-block w-100 m-3 py-3 d-frame-box rounded-5">
            <h5 class="p-0 m-0">3D</h5>
        </a>
    </div>
    <!-- 2D 3D -->
    <!-- other games -->
    <div class="row my-5">
        
        @foreach ($games as $game)
        <div class="col-6 mb-4">
            <a href="{{ $game->link }}" target="__blank" class="text-decoration-none">
                <img src="{{ $game->img_url }}" width="100%" class="rounded-4" alt="">
                <span class="d-block text-center text-white mt-2">{{ $game->name }}</span>
            </a>
        </div>
        @endforeach

        {{-- <div class="col-6 mb-4">
            <a href="">
                <img src="https://play-lh.googleusercontent.com/A79HwIntW458PJDXnIjlzGU8N6NM9H_a6FK01eh6HQtLdzPt4FY3ENUSCEPh2M5NWg=w526-h296-rw" width="100%" class="rounded-4" alt="">
            </a>
        </div>
        <div class="col-6 mb-4">
            <a href="">
                <img src="https://myanmarslotgame.com/wp-content/uploads/2023/04/photo_2_2023-02-22_23-26-57-1024x576.jpg" width="100%" class="rounded-4" alt="">
            </a>
        </div>
        <div class="col-6 mb-4">
            <a href="">
                <img src="https://www.ibet168mm.com/wp-content/uploads/2021/09/photo_2021-09-15_11-16-04-1-1024x576.jpg" width="100%" class="rounded-4" alt="">
            </a>
        </div>
        <div class="col-6 mb-4">
            <a href="">
                <img src="https://myanmarslotgame.com/wp-content/uploads/2023/03/photo_4_2023-02-22_23-26-57-1024x576.jpg" width="100%" class="rounded-4" alt="">
            </a>
        </div>
        <div class="col-6 mb-4">
            <a href="">
                <img src="https://myanmarslotgame.com/wp-content/uploads/2023/03/photo_4_2023-02-22_23-26-57-1024x576.jpg" width="100%" class="rounded-4" alt="">
            </a>
        </div> --}}
    </div>
    <!-- other games -->

</div>
<!-- content -->

@include('user_layouts.footer')
@endsection
