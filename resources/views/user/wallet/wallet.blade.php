@extends('user_layouts.master')
@section('content')
@include('user_layouts.navbar')
<div class="">
    <div
      class="headers"
      style="padding-top: 80px;"
    >
      <div class="row parent-div">
        <div class="col">
          <div class="d-flex py-2">
            <div>
              <i class="fa-regular fa-circle-user fs-1 profile-icon"></i>
            </div>
            <div class="ms-3 text-white">
              <p class="mb-0 pb-1">{{ Auth::user()->name }}</p>
              <p>လက်ကျန်ငွေ: {{ number_format(Auth::user()->balance) }} ကျပ်</p>
            </div>
          </div>
        </div>
      </div>
      <!-- profile section -->
      <div class="border border-1 rounded-3">
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
      <div class="row mt-5">
        <div class="wallet-card">
          <h5 class="text-white text-center">ငွေဖြည့်လိုပါက</h5>
          <div class="p-3 text-left text-white">
            <p>၁။ "ငွေဖြည့်" ကို နှိပ်ပါ။</p>
            <p>
              ၂။ KBZ Pay, Wave Pay, CB Pay နှင့် AYA Pay တို့မှ
              မိမိငွေဖြည့်မည့် ဘဏ်ကို ရွေးပါ။
            </p>
            <p>
              ၃။ သက်ဆိုင်ရာ Pay ဖြင့် ငွေသွင်းနိုင်သော အကောင့်များ
              ပေါ်လာပါလိမ့်မည်။
            </p>
          </div>
        </div>
      </div> 
    </div>
</div>


@include('user_layouts.footer')
@endsection
