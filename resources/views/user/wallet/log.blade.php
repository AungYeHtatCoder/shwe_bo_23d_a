@extends('user_layouts.master')
@section('content')
@include('user_layouts.navbar')
<div class="">
    <div
      class=" mt-4 pt-5 headers"
      style="padding-bottom:200px;"
    >
      
    <h6 class="text-center mt-2 pb-2" style="color: #fff">ငွေသွင်း/ထုတ်မှတ်တမ်း</h6>
    <div class="text-center mt-3">
      <p style="color: #fff; font-weight:bold;">လက်ကျန်ငွေ: {{ number_format(Auth::user()->balance) }} ကျပ်</p>
    </div>
    <div class="border border-1 rounded-3 mb-5">
      <div class="row pt-3 text-center">
        <div class="col">
          <a
            href="{{ route('user.deposit') }}"
            style="color: black; text-decoration: none"
          >
            <i  style="font-size: 25px" class="fa-solid fa-money-bill-1"></i>
            <p style="font-size: 14px; margin-top: 10px;">ငွေဖြည့်</p>
          </a>
        </div>
        <div class="col">
          <a
            href="{{ route('user.withdraw') }}"
            style="color: black; text-decoration: none"
          >
            <i  style="font-size: 25px" class="fa-solid fa-money-bill-transfer"></i>
            <p style="font-size: 14px; margin-top: 10px;">ငွေထုတ်</p>
          </a>
        </div>
        <div class="col">
          <a
            href="{{ route('user.logs') }}"
            style="color: black; text-decoration: none"
          >
            <i  style="font-size: 25px" class="fa-solid fa-pen-to-square"></i>
            <p style="font-size: 14px; margin-top: 10px;">မှတ်တမ်း</p>
          </a>
        </div>
      </div>
    </div>
    <div class="row mt-4 mb-3 mx-auto text-center">
      <div class="col-3">
        <small class="text-white">နေ့စွဲ</small>
      </div>
      <div class="col-3">
        <small class="text-white">အမျိုးအစား</small>
      </div>
      <div class="col-3">
        <small class="text-white">ပမာဏ</small>
      </div>
      <div class="col-3">
        <small class="text-white">အခြေအနေ</small>
      </div>
    </div> 
    @foreach ($logs as $log)
      <div class="row text-center mx-auto mb-2">
        <div class="col-3">
          <small class="text-white">{{ $log->created_at->format('j/m/Y') }}</small>
        </div>
        <div class="col-3">
          <small class="text-white">{{ $log->type == "Withdraw" ? "ထုတ်ငွေ" : "သွင်းငွေ" }}</small>
        </div>
        <div class="col-3">
          <small class="text-white">{{ number_format($log->amount) }} ကျပ်</small>
        </div>
        <div class="col-3">
          <small class="badge text-bg-{{ $log->status == 0 ? 'warning' :($log->status == 1 ? 'success' : 'danger') }}">{{ $log->status == 2 ? "ပယ်ချ" : ($log->status == 1 ? "အောင်မြင်" : "စောင့်ဆိုင်း") }}</small>
        </div>
      </div>
    @endforeach

  
      
    </div>
</div>


@include('user_layouts.footer')
@endsection
