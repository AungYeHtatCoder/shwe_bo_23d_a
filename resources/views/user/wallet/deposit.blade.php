@extends('user_layouts.master')

@section('content')
@include('user_layouts.navbar')
<div class="row">
   <div
      class=" mt-4 pt-5 headers"
      style="padding-bottom:200px;"
    >
    <h6 class="text-center mt-2 pb-2 text-purple">ငွေဖြည့်မည်</h6>
    <div class="text-center mt-3">
      <p style="font-weight:bold;" class=" text-purple">လက်ကျန်ငွေ: {{ number_format(Auth::user()->balance) }} ကျပ်</p>
    </div>
    <p class="mb-4 text-purple">{{ $bank->bank }} ထဲ ငွေဖြည့်ပါ။ </p>
    <hr class=" text-purple"/>
    <div class="row">
        <div class="col-4">
            <img src="{{ $bank->img_url }}" class="w-100 rounded shadow" alt="">
        </div>
        <div class="col-8">
            <form action="{{ route('user.deposit') }}" method="post">
                @csrf
                <input type="hidden" name="payment_method" value="{{ $bank->bank }}">
                <div class="mb-3">
                    <label for="" class="form-label text-purple mb-2">ဖုန်း(သို့)ဘဏ်နံပါတ်</label>
                    <input type="number" placeholder="Enter Phone or Bank No" name="phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label text-purple mb-2">ပမာဏဖြည့်ရန်</label>
                    <input type="number" placeholder="Enter Amount" name="amount" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label text-purple mb-2">နောက်ဆုံးဂဏန်း ၆လုံးဖြည့်ပါ</label>
                    <input type="number" placeholder="Enter Last 6 number" name="last_6_num" class="form-control">
                </div>
                <div class="text-end">
                    <button class="btn btn-purple text-white" type="submit">ဖောင်ပို့မည်။</button>
                </div>
            </form>
        </div>
    </div>



    
  </div>
</div>


@include('user_layouts.footer')
@endsection
@section('script')


@endsection
