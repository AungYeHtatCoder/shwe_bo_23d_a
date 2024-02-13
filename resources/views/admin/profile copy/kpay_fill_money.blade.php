@extends('layouts.admin_app')
@section('styles')
<style>
.transparent-btn {
 background: none;
 border: none;
 padding: 0;
 outline: none;
 cursor: pointer;
 box-shadow: none;
 appearance: none;
 /* For some browsers */
}


.custom-form-group {
 margin-bottom: 20px;
}

.custom-form-group label {
 display: block;
 margin-bottom: 5px;
 font-weight: bold;
 color: #555;
}

.custom-form-group input,
.custom-form-group select {
 width: 100%;
 padding: 10px 15px;
 border: 1px solid #e1e1e1;
 border-radius: 5px;
 font-size: 16px;
 color: #333;
}

.custom-form-group input:focus,
.custom-form-group select:focus {
 border-color: #d33a9e;
 box-shadow: 0 0 5px rgba(211, 58, 158, 0.5);
}

.submit-btn {
 background-color: #d33a9e;
 color: white;
 border: none;
 padding: 12px 20px;
 border-radius: 5px;
 cursor: pointer;
 font-size: 18px;
 font-weight: bold;
}

.submit-btn:hover {
 background-color: #b8328b;
}
</style>
@endsection
@section('content')

<div class="row">
 <div class="col-12">
  <div class="container mb-3">
   <a class="btn btn-icon btn-2 btn-primary float-end me-5" href="{{ route('admin.profiles.index') }}">
    <span class="btn-inner--icon mt-1"><i class="material-icons">arrow_back</i>Back</span>
   </a>
  </div>
  <div class="container my-auto mt-5">
   <div class="row">
    <div class="col-lg-10 col-md-2 col-12 mx-auto">
     <div class="card z-index-0 fadeIn3 fadeInBottom">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
       <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1">
        <h4 class="text-white font-weight-bolder text-center mb-2">Fill Money</h4>
       </div>
      </div>
      <div class="card-body">
       <form role="form" class="text-start" action="">
        <div class="custom-form-group row">
         <label for="title">ဖုန်းနံပါတ်များ</label>
         <input type="text" id="title" name="title" class="form-control" value="{{ Auth::user()->kpay_no }}">
        </div>
        <div class="custom-form-group row">
         <h5 class="mt-3">ငွေဖြည့်နည်း</h5>
         <ul class="text-muted ps-4 mb-0 float-start" style="list-style: none;">
          <li>
           <span class="text-sm">၁ : ငွေလွှဲမည့်ဖုန်းနံပါတ်ကို ကူးယူပါ</span>
          </li>
          <li>
           <span class="text-sm">၂: User Name (K pay) မှ ငွေလွှဲပါ</span>
          </li>
          <li>
           <span class="text-sm">၃: ငွေလွှဲပြီးရလာသော လုပ်ငန်းစဉ်အမှတ် နောက်ဆုံး ၆ လုံးအောက်တွင်ဖြည့်ပါ</span>
          </li>
          <li>
           <span class="text-sm">၄: ငွေဖြည့်မည်ကို နှိပ်ပါ</span>
          </li>
         </ul>
        </div>
        <div class="custom-form-group row">
         <label for="title">လုပ်ငန်းစဉ်အမှတ် နောက်ဆုံး ၆ လုံးကိုဖြည့်ပါ</label>
         <input type="text" id="title" name="six_digit" class="form-control">
        </div>
        <div class="custom-form-group d-flex justify-content-center">
         <button class="btn btn-primary" type="button">ငွေဖြည့်မည်</button>
        </div>
       </form>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>

@endsection