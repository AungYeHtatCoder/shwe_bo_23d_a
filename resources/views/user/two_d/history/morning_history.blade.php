@extends('user_layouts.master')
@section('style')

<style>
 .winner-table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  border: 1px solid #ddd;
 }

 .winner-table th,
 .winner-table td {
  text-align: left;
  padding: 8px;
 }

 .winner-table th {
  background-color: #f5bd02;
  color: rgb(18, 3, 3);
  font-size: 20px;
 }

 .winner-table tr:nth-child(even) {
  background-color: #4110d4;
 }

 .winner-table tr:hover {
  background-color: #c108b8;
 }

 .winner-table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #f5bd02;
  color: rgb(15, 2, 2);
 }
</style>
@section('content')
@include('user_layouts.navbar')
<div class="container-fluid py-5 mt-5">
 <div class="nine-thirty pb-5 pt-2">
  <h5 class="text-center text-purple">2D မနက်ပိုင်းမှတ်တမ်း</h5>
  <div class="card mt-2 bg-transparent shadow border border-1">
   <div class="card-header">
<<<<<<< HEAD
    <p class="text-center text-dark">
=======
    <p class="text-center text-purple">
>>>>>>> c829e29f6819f9d9fb2fc02b3970787172df5524
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

  {{-- <div>

   <span class="font-weight-bold" style="font-size: 30px;color: #fff">{{ $winners->count() }}
    @if($winners->count() > 1)
    ကံထူးရှင်များ
    @else
    ကံထူးရှင်များ
    @endif
   </span>
  </div> --}}

  <div class="p-1 mt-3" style="border-bottom: 200px;">
   {{-- @if($winners->isEmpty())
   <p style="color: #f5bd02">No winners found for the past month.</p>
   @else --}}
<<<<<<< HEAD
   <table class="winner-table table table-striped">
=======
   <table class="table text-center">
>>>>>>> c829e29f6819f9d9fb2fc02b3970787172df5524
    <thead>
            <tr>
                <th class="text-purple">#</th>
                <th class="text-purple">Two Digit</th>
                <th class="text-purple">Sub Amount</th>
                <th class="text-purple">Prize Sent</th>
                <th class="text-purple">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($morningData as $index => $data)
                @foreach($data->twoDigits as $twoDigit)
                <tr>
<<<<<<< HEAD
                    <td>{{ $index + 1 }}</td>
                    {{-- <td>{{ $twoDigit->two_digit }}</td> --}}
                     <td>{{ $twoDigit->pivot->bet_digit }}</td> {{-- Displaying bet_digit --}}
                    <td>{{ $twoDigit->pivot->sub_amount }}</td>
                    <td>
=======
                    <td class="text-purple">{{ $index + 1 }}</td>
                    <td class="text-purple">{{ $twoDigit->two_digit }}</td>
                    <td class="text-purple">{{ $twoDigit->pivot->sub_amount }}</td>
                    <td class="text-purple">
>>>>>>> c829e29f6819f9d9fb2fc02b3970787172df5524
                        @if($twoDigit->pivot->prize_sent == 1)
                            <span class="text-success">Win</span>
                        @else
                            <span class="text-danger">Pending</span>
                        @endif
                        
                    </td>
                    <td class="text-purple">{{ $twoDigit->pivot->created_at->format('d-m-Y H:iA') }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
   </table>
   {{-- show total amount --}}
    <div class="text-center">
<<<<<<< HEAD
     <h5 class="text-dark">Total Morning Sub Amount: {{ $totalMorningSubAmount }}
=======
     <h5 class="text-purple">Total Morning Sub Amount: {{ number_format($totalMorningSubAmount) }}
>>>>>>> c829e29f6819f9d9fb2fc02b3970787172df5524
 MMK</h5>
    </div>
   {{-- @endif --}}

  </div>
 </div>

</div>

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