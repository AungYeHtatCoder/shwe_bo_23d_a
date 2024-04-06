@extends('user_layouts.master')

@section('style')
<style>
    #main{
        max-height: 100vh;
    }
    .list-group{
        height: 450px;
        overflow: scroll;
        padding: 0 0 100px 0;
    }
</style>
@endsection

@section('content')
@include('user_layouts.navbar')
<!-- content -->
<div class="container-fluid position-relative py-1 pb-5 my-5" id="main">
 <!-- bet action section  -->
 <div class="d-sm-flex justify-content-around text-center mt-4">
  <div class="py-3  px-5 bg-purple rounded-4 shadow">
   <h1 class="fw-bold ls-wide" id="3d_live" style="font-size:5rem; font-family: 'Gabarito', sans-serif; letter-spacing: 7px;">821
   </h1>
   <span>Updated Date: <span class="text-warning" id="updated_date"></span></span>
  </div>
  <div class="my-1 text-center align-self-center">
    <a href="{{ url('/user/three-d-choice-play-index') }}" class="btn btn-purple p-2 rounded-2 text-white text-center">
     3D ထိုးမယ်
     <i class="fas fa-arrow-right text-warning"></i>
    </a>
   </div>
 </div>

 <!-- bet action section  -->
 <div class="mt-4">
  <ul class="list-group" id="result">

   {{-- <li class="rounded-3 list-group-item my-2 threed_list bg-transparent">
    <div class="d-flex justify-content-between align-items-center">
     <div>
      <h5>Date</h5>
      <span class="text-info">07.11.2023</span>
     </div>
     <div>
      <h5>3D</h5>
      <span class="text-warning">351</span>
     </div>
    </div>
   </li>
   <li class="rounded-3 list-group-item my-2 threed_list bg-transparent">
    <div class="d-flex justify-content-between align-items-center">
     <div>
      <h5>Date</h5>
      <span class="text-info">07.11.2023</span>
     </div>
     <div>
      <h5>3D</h5>
      <span class="text-warning">402</span>
     </div>
    </div>
   </li>
   <li class="rounded-3 list-group-item my-2 threed_list bg-transparent">
    <div class="d-flex justify-content-between align-items-center">
     <div>
      <h5>Date</h5>
      <span class="text-info">07.11.2023</span>
     </div>
     <div>
      <h5>3D</h5>
      <span class="text-warning">604</span>
     </div>
    </div>
   </li>
   <li class="rounded-3 list-group-item my-2 threed_list bg-transparent">
    <div class="d-flex justify-content-between align-items-center">
     <div>
      <h5>Date</h5>
      <span class="text-info">07.11.2023</span>
     </div>
     <div>
      <h5>3D</h5>
      <span class="text-warning">120</span>
     </div>
    </div>
   </li>
   <li class="rounded-3 list-group-item my-2 threed_list bg-transparent">
    <div class="d-flex justify-content-between align-items-center">
     <div>
      <h5>Date</h5>
      <span class="text-info">07.11.2023</span>
     </div>
     <div>
      <h5>3D</h5>
      <span class="text-warning">754</span>
     </div>
    </div>
   </li>
   <li class="rounded-3 list-group-item my-2 threed_list bg-transparent">
    <div class="d-flex justify-content-between align-items-center">
     <div>
      <h5>Date</h5>
      <span class="text-info">07.11.2023</span>
     </div>
     <div>
      <h5>3D</h5>
      <span class="text-warning">352</span>
     </div>
    </div>
   </li> --}}
  </ul>
 </div>
</div>
<!-- content -->

@include('user_layouts.footer')
@endsection

@section('script')
<script>
    async function fetchData() {
      const url = 'https://shwe-2d-live-api.p.rapidapi.com/3d-live';
      const options = {
        method: 'GET',
        headers: {
          'X-RapidAPI-Key': '53aaa0f305msh5cdcf7afaacaedcp11a2d2jsn2453bc4f2507',
          'X-RapidAPI-Host': 'shwe-2d-live-api.p.rapidapi.com'
        }
      };

      try {
        const response = await fetch(url, options);
        const result = await response.json(); // Parse the response as JSON


        $("#3d_live").text(result[0].num)
        $("#updated_date").text(result[0].date)

        let newHTML = '';
        result.forEach(r => {
            newHTML += `
            <li class="rounded-3 list-group-item my-2 threed_list bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                <div>
                <h5>Date</h5>
                <span class="text-info">${r.date}</span>
                </div>
                <div>
                <h5>3D</h5>
                <span class="text-warning">${r.num}</span>
                </div>
                </div>
            </li>
            `;
            });
            $('#result').html(newHTML);

      } catch (error) {
        console.error(error);
      }
    }
    fetchData();
</script>

@endsection
