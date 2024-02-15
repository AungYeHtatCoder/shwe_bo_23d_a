@extends('user_layouts.master')

@section('content')
@include('user_layouts.navbar')
<div class="row">
   <div
      class=" mt-4 pt-5 headers"
      style="padding-bottom:200px;"
    >
    <h6 class="text-center mt-2 pb-2 text-purple" >ငွေဖြည့်မည်</h6>
    <div class="text-center mt-3">
      <p style="font-weight:bold;" class=" text-purple">လက်ကျန်ငွေ: {{ number_format(Auth::user()->balance) }} ကျပ်</p>
    </div>
    <div class="border border-1 border-purple rounded-3 mb-5">
      <div class="row pt-3 text-center">
        <div class="col">
          <a
            href="{{ route('user.deposit') }}"
            style="color: black; text-decoration: none"
          >
            <i  style="font-size: 25px" class="fa-solid fa-money-bill-1 text-purple"></i>
            <p style="font-size: 14px; margin-top: 10px;" class=" text-purple">ငွေဖြည့်</p>
          </a>
        </div>
        <div class="col">
          <a
            href="{{ route('user.withdraw') }}"
            style="color: black; text-decoration: none"
          >
            <i  style="font-size: 25px" class="fa-solid fa-money-bill-transfer text-purple"></i>
            <p class=" text-purple" style="font-size: 14px; margin-top: 10px;">ငွေထုတ်</p>
          </a>
        </div>
        <div class="col">
          <a
            href="{{ route('user.logs') }}"
            style="color: black; text-decoration: none"
          >
            <i  style="font-size: 25px" class="fa-solid fa-pen-to-square text-purple"></i>
            <p class=" text-purple" style="font-size: 14px; margin-top: 10px;">မှတ်တမ်း</p>
          </a>
        </div>
      </div>
    </div>
    <p  class="mb-4 text-purple">မိမိ ငွေဖြည့်မည့်ဘဏ်တစ်ခုရွေးပါ</p>
    <div class="top-up-card row">
      @foreach ($banks as $bank)
        <div class="col-md-2 col-6 mb-4">
          <a href="{{ url('/user/deposit/'.$bank->id) }}">
          <div class="banks blur-image">
            <img src="{{ $bank->img_url }}" class="w-100 rounded shadow" alt="" />
          </div>
        </a>
        </div>
      @endforeach
    </div>


    <hr style="color:#fff;"/>

    <div class="row">
      <div class="container" id="top-up-form" style="display: none">
       <form action="">
        @foreach ($banks as $bank)
        <div class="form-group mt-2">
          <a href="{{ url('/user/fill-balance-top-up-submit/'.$bank->id) }}" class="btn top-up-btn text-white">{{ $bank->bank }} - ဆက်လုပ်ရန်</a>
        </div>
        @endforeach
        </form>
      </div>
    </div>
  </div>
</div>


@include('user_layouts.footer')
@endsection
@section('script')


@endsection
