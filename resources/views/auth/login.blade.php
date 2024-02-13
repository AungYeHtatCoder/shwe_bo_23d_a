@extends('frontend.layouts.app')
@section('content')
<div class="row">
    <div
      class="col-lg-4 col-md-4 offset-lg-4 offset-md-4 mt-4 py-4 headers"
      style="height:100vh;"
    >
    <img src="{{ asset('user_app/assets/images/login.jpg') }}" class="w-100 mt-4" alt="" />
    <form action="{{ route('login') }}" method="POST">
        @csrf
      <div class="mb-4">
      <div class="input-group">
      <input
        type="text"
        name="login"
        class="form-control w-75 py-2 my-4 mx-auto"
        placeholder="ဖုန်းနံပါတ် (သို့) အီးမေးလ်"
      />
      </div>
                    @error('login')
                    <span class="text-danger d-block ps-3 pt-2">{{ "The email or phone field is required." }}</span>
                    @enderror
      </div>
      <div class="mb-4">
      <div class="input-group">
     <span class="input-group-text bg-white border border-0"><i class="fas fa-key text-purple"></i></span>
                        <input type="password" name="password" id="password" class="form-control border border-0" placeholder="လျှို့ဝှက်နံပါတ်ထည့်ပါ">
                        <span class="input-group-text bg-white border border-0"><i class="fas fa-eye text-purple" id="eye" onclick="PwdView()" style="cursor: pointer;"></i></span>
      </div>
                    @error('password')
                    <span class="text-danger d-block ps-3 pt-2">{{ $message }}</span>
                    @enderror
      </div>

      <div class="d-flex justify-content-end align-items-center me-5">
        <small
          ><a href="#" style="text-decoration: none; color: #f5bd02;" class="me-3"
            >လျှို့ဝှက်နံပါတ် မေ့နေပါသလား။</a
          ></small
        >
      </div>

      <div class="d-flex justify-content-center align-items-center">
        <button
          type="submit"
          name="signin_btn"
          class="btns w-75 mt-4"
        >
          ၀င်မည်
        </button>
      </div>

      <hr />

      <div class="d-flex justify-content-center align-items-center">
        <a
          href="{{ url('/register') }}"
          type="button"
          name="signin_btn"
          class="btn btn-outline-success w-75 mx-auto mt-4 py-2"
          style="text-decoration: none; box-shadow: 3px 5px 10px 0 rgba(0, 0, 0, 0.2),
          3px 5px 10px 0 rgba(0, 0, 0, 0.19);"
          >အကောင့် အသစ်ဖွင့်မည်</a
        >
      </div>
    </form>
    </div>
</div>
{{-- @include('frontend.layouts.footer') --}}
@endsection
@section('script')
<script>
    function PwdView() {
        var x = document.getElementById("password");
        var y = document.getElementById("eye");

        if (x.type === "password") {
            x.type = "text";
            y.classList.remove('fa-eye');
            y.classList.add('fa-eye-slash');
        } else {
            x.type = "password";
            y.classList.remove('fa-eye-slash');
            y.classList.add('fa-eye');
        }
    }
</script>
@endsection
