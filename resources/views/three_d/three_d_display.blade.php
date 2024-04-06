@extends('user_layouts.master')

@section('style')
<style>
  .btn-outline-purple {
    border: 1px solid #a202ff;
    color: #fff;
  }

  .btn-outline-purple:hover {
    background: #a202ff;
    color: #fff;
  }

  #profile-nav {
    /* border-radius: 40px 40px 0 0; */
    background: transparent;
    /* border: 1px solid #a202ff; */
    /* box-shadow: 2px 3px 4px #c155ff; */
  }

  .nav-btn {
    width: 100%;
    height: 100px;
    /* border: 1px solid #a202ff; */

  }

  .nav-btn:hover {
    box-shadow: 2px 3px 4px #fff;
    color: #fff !important;
    border: 1px solid #fff;
  }

  .click {
    box-shadow: 2px 3px 4px #fff;
    color: #fff !important;
    border: 1px solid #fff;
  }

  .icon-text {
    font-size: 25px;
    color: #fff;
  }

  .nav-text {
    font-size: 16px;
    color: #fff;
  }

  .input-group {
    border-radius: 30px !important;
    background: #fff;
    padding: 5px;
  }

  .fa-user-circle {
    font-size: 25px;
  }

  input:focus {
    box-shadow: none !important;
    border: none !important;
  }
</style>
@endsection

@section('content')
@include('user_layouts.navbar')
<!-- content -->
<div class="container-fluid py-5 mt-5">
  <div class="nine-thirty pb-5 pt-2">
    <h5 class="text-center">တစ်ပါတ်အတွင်း 3D ထိုး မှတ်တမ်း </h5>
    <div class="card mt-2 bg-transparent shadow border border-1">
      <div class="card-header">
        <p class="text-center text-white">
          <script>
            var d = new Date();
            document.write(d.toLocaleDateString());
          </script>
          <br />
          <script>
            var d = new Date();
            document.write(d.toLocaleTimeString());
          </script>
        </p>
      </div>
    </div>
    <table class="table text-center">
      <thead>
        <tr>
          <th>No</th>
          <th>3D</th>
          <th>ထိုးကြေး</th>
        </tr>
      </thead>
      <tbody>
        @if(isset($displayThreeDigits['threeDigit']) && count($displayThreeDigits['threeDigit']) == 0)
        <p class="text-center text-white px-3 py-2 mt-3" style="background-color: #c50408">
          ကံစမ်းထားသော 3D ထီဂဏန်းများ မရှိသေးပါ
          <span>
            <a href="{{ url('/user/three-d-choice-play-index')}}" style="color: #f5bd02; text-decoration:none">
              <strong>ထီးထိုးရန် နိုပ်ပါ</strong></a>
          </span>
        </p>
        @endif

        @if($displayThreeDigits)
        @foreach ($displayThreeDigits['threeDigit'] as $index => $digit)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $digit->three_digit }}</td>
          <td>{{ $digit->pivot->sub_amount }}</td>
        </tr>
        @endforeach
        @endif
      </tbody>
    </table>
    <div class="mb-3 d-flex justify-content-around text-white p-2 rounded shadow border border-1">
      <p class="text-end pt-1" style="color: #ffffff">Total Amount for 3D: ||&nbsp; &nbsp; စုစုပေါင်းထိုးကြေး
        <strong>{{ $displayThreeDigits['total_amount'] }} MMK</strong>
      </p>
    </div>
  </div>

</div>
<!-- content -->

@include('user_layouts.footer')
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    @if(session('SuccessRequest'))
    Swal.fire({
      icon: 'success',
      title: 'Success! သင့်ကံစမ်းမှုအောင်မြင်ပါသည် ! သိန်းထီးဆုကြီးပေါက်ပါစေ',
      text: '{{ session('
      SuccessRequest ') }}',
      timer: 3000,
      showConfirmButton: false
    });
    @endif
  });
</script>
@endsection