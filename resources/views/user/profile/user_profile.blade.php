@extends('user_layouts.master')

@section('style')
<style>
    .btn-outline-purple{
        border: 1px solid #a202ff;
        color: #fff;
    }
    .btn-outline-purple:hover{
        background:#a202ff;
        color: #fff;
    }
    #profile-nav{
        /* border-radius: 40px 40px 0 0; */
        background: transparent;
        /* border: 1px solid #a202ff; */
        /* box-shadow: 2px 3px 4px #c155ff; */
    }
    .nav-btn{
        width: 100%;
        height: 100px;
        /* border: 1px solid #a202ff; */

    }
    .nav-btn:hover{
        box-shadow: 2px 3px 4px #fff;
        color: #fff !important;
        border: 1px solid #fff;
    }
    .click{
        box-shadow: 2px 3px 4px #fff;
        color: #fff !important;
        border: 1px solid #fff;
    }
    .icon-text{
        font-size: 25px;
        color: #fff;
    }
    .nav-text{
        font-size: 16px;
        color: #fff;
    }
    .input-group{
        border-radius: 30px !important;
        background: #fff;
        padding: 5px;
    }
    .fa-user-circle{
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
    <div class="mb-4 text-center">
        <div class="m-auto">
            @if (Auth::user()->profile)
            <img src="{{ Auth::user()->profile }}" width="80px" height="80px" class="rounded-circle border-purple" alt="">
            @else
            <i class="fa-regular fa-user-circle text-white fa-4x"></i>
            @endif
            <div class="ms-4 mt-3">
                <h4>{{ Auth::user()->name }}</h4>
                <p><i class="fas fa-money-bills me-2"></i>{{ number_format(Auth::user()->balance) }} MMK</p>
                @if (Auth::user()->phone)
                <p><i class="fas fa-phone-volume me-2 mb-0"></i>{{ Auth::user()->phone }}</p>
                @endif
                @if (Auth::user()->email)
                <p><i class="fas fa-envelope me-2 mt-0"></i>{{ Auth::user()->email }}</p>
                @endif
                @if (Auth::user()->address)
                <p><i class="fas fa-location-dot me-2"></i>{{ Auth::user()->address }}</p>
                @endif
            </div>
            <a href="" class="btn btn-sm btn-outline-light">ငွေသွင်းမည်</a>
            <a href="" class="btn btn-sm btn-outline-light">ငွေထုတ်မည်</a>
        </div>
    </div>
    <div id="profile-nav">
        <div class="d-flex justify-content-between">
            <button class="btn nav-btn d-block click" id="profile">
                <i class="icon-text fa-regular fa-user-circle d-block mb-2"></i>
                <span class="nav-text">Profile</span>
            </button>
            <button class="btn nav-btn d-block" id="nine-thirty">
                <i class="icon-text fas fa-clock d-block mb-2"></i>
                <span class="nav-text">09:30 AM</span>
            </button>
            <button class="btn nav-btn d-block" id="twelve">
                <i class="icon-text fas fa-clock d-block mb-2"></i>
                <span class="nav-text">12:00 PM</span>
            </button>
            <button class="btn nav-btn d-block" id="two">
                <i class="icon-text fas fa-clock d-block mb-2"></i>
                <span class="nav-text">02:00 PM</span>
            </button>
            <button class="btn nav-btn d-block" id="four-thirty">
                <i class="icon-text fas fa-clock d-block mb-2"></i>
                <span class="nav-text">04:30 PM</span>
            </button>
        </div>
    </div>
    <div class="profile">
        <div class="pt-5 text-white">
            <p class="text-start mb-3"><i class="fas fa-user-pen me-2"></i>Edit Profile</p>
            <form action="{{ route('user.editProfile', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="">
                    <div class="input-group">
                        <span class="input-group-text bg-white border border-0"><i class="fa-regular fa-user-circle text-purple"></i></span>
                        <input type="file" name="profile" class="form-control border border-0">
                        <button class="input-group-text bg-white border border-0" style="cursor: pointer;" type="submit">
                            Edit
                        </button>
                    </div>
                    @error('profile')
                    <span class="text-danger d-block ps-3 pt-2">{{ $message }}</span>
                    @enderror
                </div>
            </form>
        </div>
        {{-- edit profile info --}}
        <div class="pt-5 text-white">
            <p class="text-start mb-3"><i class="fas fa-user-pen me-2"></i>Edit Info</p>
            <form action="{{ route('user.editInfo') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border border-0">
                                    <i class="fa-regular fa-user-circle text-purple"></i>
                                </span>
                                <input type="text" name="name" class="form-control border border-0" placeholder="အမည်" value="{{ Auth::user()->name }}">
                            </div>
                            @error('name')
                            <span class="text-danger d-block ps-3 pt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border border-0"><i class="fa-regular fa-envelope text-purple"></i></span>
                                <input type="email" name="email" class="form-control border border-0" placeholder="အီးမေးလ်" value="{{ Auth::user()->email ?? "" }}">
                            </div>
                            @error('email')
                            <span class="text-danger d-block ps-3 pt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border border-0">
                                    <i class="fas fa-phone-volume text-purple"></i>
                                </span>
                                <input type="number" name="phone" class="form-control border border-0" placeholder="ဖုန်းနံပါတ်" value="{{ Auth::user()->phone ?? "" }}">
                            </div>
                            @error('phone')
                            <span class="text-danger d-block ps-3 pt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border border-0"><i class="fas fa-location-dot text-purple"></i></span>
                                <input type="text" name="address" class="form-control border border-0" placeholder="နေရပ်လိပ်စာ" value="{{ Auth::user()->address ?? "" }}">
                            </div>
                            @error('address')
                            <span class="text-danger d-block ps-3 pt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn-outline-light" type="submit">Edit</button>
                </div>
            </form>
        </div>
        {{-- Change PWD --}}
        <div class="py-5 text-white">
            <p class="text-start mb-3"><i class="fas fa-key me-2"></i>Change Password</p>
            <form action="{{ route('user.changePassword') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border border-0"><i class="fas fa-key text-purple"></i></span>
                                <input type="password" name="old_password" id="password" class="form-control border border-0" placeholder="လျှို့ဝှက်နံပါတ်ထည့်ပါ">
                                <span class="input-group-text bg-white border border-0"><i class="fas fa-eye text-purple" id="eye" onclick="PwdView()" style="cursor: pointer;"></i></span>
                            </div>
                            @error('old_password')
                            <span class="text-danger d-block ps-3 pt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border border-0"><i class="fas fa-key text-purple"></i></span>
                                <input type="password" name="password" id="password1" class="form-control border border-0" placeholder="လျှို့ဝှက်နံပါတ်ထပ်ထည့်ပါ">
                                <span class="input-group-text bg-white border border-0"><i class="fas fa-eye text-purple" id="eye1" onclick="PwdView1()" style="cursor: pointer;"></i></span>
                            </div>
                            @error('password')
                            <span class="text-danger d-block ps-3 pt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn-outline-light" type="submit">Change</button>
                </div>
            </form>
        </div>
    </div>

    <div class="nine-thirty py-5 d-none">
        <p class="text-center">တစ်နေ့တာ 2D ထိုးမှတ်တမ်း</p>
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
                    <th>2D</th>
                    <th>ထိုးကြေး</th>
                </tr>
            </thead>
            <tbody>
                {{-- @if ($earlymorningDigits)
                    @foreach ($earlymorningDigits['two_digits'] as $index => $digit)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $digit->two_digit }}</td>
                        <td>{{ $digit->pivot->sub_amount }}</td>
                    </tr>
                    @endforeach
                @endif --}}
            </tbody>
        </table>
        <div class="mb-3 d-flex justify-content-around text-white p-2 rounded shadow border border-1">
            <p class="text-end pt-1" style="color: #ffffff">Total Amount for 09:30AM: ||&nbsp; &nbsp; စုစုပေါင်းထိုးကြေး
                {{-- <strong>{{ $earlymorningDigits['total_amount'] }} MMK</strong> --}}
            </p>
        </div>
    </div>

    <div class="twelve py-5 d-none">
        <p class="text-center">တစ်နေ့တာ 2D ထိုးမှတ်တမ်း</p>
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
                    <th>2D</th>
                    <th>ထိုးကြေး</th>
                </tr>
            </thead>
            <tbody>
                {{-- @if ($morningDigits)
                    @foreach ($morningDigits['two_digits'] as $index => $digit)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $digit->two_digit }}</td>
                        <td>{{ $digit->pivot->sub_amount }}</td>
                    </tr>
                    @endforeach
                @endif --}}
            </tbody>
        </table>
        <div class="mb-3 d-flex justify-content-around text-white p-2 rounded shadow border border-1">
            <p class="text-end pt-1" style="color: #ffffff">Total Amount for 12:00PM: ||&nbsp; &nbsp; စုစုပေါင်းထိုးကြေး
                {{-- <strong>{{ $morningDigits['total_amount'] }} MMK</strong> --}}
            </p>
        </div>
    </div>

    <div class="two py-5 d-none">
        <p class="text-center">တစ်နေ့တာ 2D ထိုးမှတ်တမ်း</p>
        {{-- @if(isset($earlyeveningDigit['two_digits']) && count($eveningDigits['two_digits']) == 0)
            <p class="text-center text-white px-3 py-2 mt-3" style="background-color: #c50408">
                ညနေပိုင်း ကံစမ်းထားသော ထီဂဏန်းများ မရှိသေးပါ
                <span>
                    <a href="{{ route('admin.GetTwoDigit')}}" style="color: #f5bd02; text-decoration:none">
                        <strong>ထီးထိုးရန် နိုပ်ပါ</strong></a>
                </span>
            </p>
        @endif --}}
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
                    <th>2D</th>
                    <th>ထိုးကြေး</th>
                </tr>
            </thead>
            <tbody>
                {{-- @if ($earlyeveningDigit)
                    @foreach ($earlyeveningDigit['two_digits'] as $index => $digit)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $digit->two_digit }}</td>
                        <td>{{ $digit->pivot->sub_amount }}</td>
                    </tr>
                    @endforeach
                @endif --}}
            </tbody>
        </table>
        <div class="mb-3 d-flex justify-content-around text-white p-2 rounded shadow border border-1">
            <p class="text-end pt-1" style="color: #ffffff">Total Amount for 02:00PM: ||&nbsp; &nbsp; စုစုပေါင်းထိုးကြေး
                {{-- <strong>{{ $earlyeveningDigit['total_amount'] }} MMK</strong> --}}
            </p>
        </div>
    </div>

    <div class="four-thirty py-5 d-none">
        <p class="text-center">တစ်နေ့တာ 2D ထိုးမှတ်တမ်း</p>
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
                    <th>2D</th>
                    <th>ထိုးကြေး</th>
                </tr>
            </thead>
            <tbody>
                {{-- @if ($eveningDigits)
                    @foreach ($eveningDigits['two_digits'] as $index => $digit)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $digit->two_digit }}</td>
                        <td>{{ $digit->pivot->sub_amount }}</td>
                    </tr>
                    @endforeach
                @endif --}}
            </tbody>
        </table>
        <div class="mb-3 d-flex justify-content-around text-white p-2 rounded shadow border border-1">
            <p class="text-end pt-1" style="color: #ffffff">Total Amount for 04:30AM: ||&nbsp; &nbsp; စုစုပေါင်းထိုးကြေး
                {{-- <strong>{{ $eveningDigits['total_amount'] }} MMK</strong> --}}
            </p>
        </div>
    </div>

</div>
<!-- content -->

@include('user_layouts.footer')
@endsection

@section('script')
<script>
    $(document).ready(function(){
        $("#profile").click(function(){
            $(".profile").removeClass('d-none');
            $(".nine-thirty").addClass('d-none');
            $(".twelve").addClass('d-none');
            $(".two").addClass('d-none');
            $(".four-thirty").addClass('d-none');

            $('#profile').addClass('click');
            $('#nine-thirty').removeClass('click');
            $('#twelve').removeClass('click');
            $('#two').removeClass('click');
            $('#four-thirty').removeClass('click');
        })
        $("#nine-thirty").click(function(){
            $(".profile").addClass('d-none');
            $(".nine-thirty").removeClass('d-none');
            $(".twelve").addClass('d-none');
            $(".two").addClass('d-none');
            $(".four-thirty").addClass('d-none');

            $('#profile').removeClass('click');
            $('#nine-thirty').addClass('click');
            $('#twelve').removeClass('click');
            $('#two').removeClass('click');
            $('#four-thirty').removeClass('click');
        })
        $("#twelve").click(function(){
            $(".profile").addClass('d-none');
            $(".nine-thirty").addClass('d-none');
            $(".twelve").removeClass('d-none');
            $(".two").addClass('d-none');
            $(".four-thirty").addClass('d-none');

            $('#profile').removeClass('click');
            $('#nine-thirty').removeClass('click');
            $('#twelve').addClass('click');
            $('#two').removeClass('click');
            $('#four-thirty').removeClass('click');
        })
        $("#two").click(function(){
            $(".profile").addClass('d-none');
            $(".nine-thirty").addClass('d-none');
            $(".twelve").addClass('d-none');
            $(".two").removeClass('d-none');
            $(".four-thirty").addClass('d-none');

            $('#profile').removeClass('click');
            $('#nine-thirty').removeClass('click');
            $('#twelve').removeClass('click');
            $('#two').addClass('click');
            $('#four-thirty').removeClass('click');
        })
        $("#four-thirty").click(function(){
            $(".profile").addClass('d-none');
            $(".nine-thirty").addClass('d-none');
            $(".twelve").addClass('d-none');
            $(".two").addClass('d-none');
            $(".four-thirty").removeClass('d-none');

            $('#profile').removeClass('click');
            $('#nine-thirty').removeClass('click');
            $('#twelve').removeClass('click');
            $('#two').removeClass('click');
            $('#four-thirty').addClass('click');
        })
    })
</script>
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
    function PwdView1() {
        var x = document.getElementById("password1");
        var y = document.getElementById("eye1");

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

