@extends('user_layouts.master')

@section('content')
@include('user_layouts.navbar')
<div class="row">
   <div
      class=" mt-4 pt-5 headers"
      style="padding-bottom:200px;"
    >
    <h6 class="text-center mt-2 pb-2 text-purple">ငွေထုတ်မည်</h6>
    <div class="text-center mt-3">
      <p class=" text-purple" style="font-weight:bold;">လက်ကျန်ငွေ: {{ number_format(Auth::user()->balance) }} ကျပ်</p>
    </div>
    <p style="" class="mb-4 text-purple">{{ $bank->bank }} မှ ငွေထုတ်ပါ။ </p>
    <hr style="color:#fff;"/>
    <div class="row">
        <div class="col-4">
            <img src="{{ $bank->img_url }}" class="w-100 rounded shadow" alt="">
        </div>
        <div class="col-8">
            <form action="{{ route('user.withdraw') }}" method="post">
                @csrf
                <input type="hidden" name="payment_method" value="{{ $bank->bank }}">
                <div class="mb-3">
                    <label for="" class="form-label text-purple mb-2">ဖုန်း(သို့)ဘဏ်နံပါတ်</label>
                    <input type="number" placeholder="Enter Phone or Bank No" name="phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label text-purple mb-2">ဖုန်း(သို့)ဘဏ် ပိုင်ရှင်အမည်</label>
                    <input type="text" placeholder="Enter Phone or Bank Owner" name="name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label text-purple mb-2">ပမာဏဖြည့်ရန်</label>
                    <input type="number" placeholder="Enter Amount" name="amount" class="form-control">
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
