@extends('user_layouts.master')
@section('content')
@include('user_layouts.navbar')
<div class="container-fluid py-5 mt-5">
 <div class="nine-thirty pb-5 pt-2">
  <h5 class="text-center text-purple">2D မနက်ပိုင်းမှတ်တမ်း</h5>
  <div class="card mt-2 bg-transparent shadow border border-1">
   <div class="card-header">
    <p class="text-center text-purple">
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
   <table class="table text-center">
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
                    <td class="text-purple">{{ $index + 1 }}</td>
                    <td class="text-purple">{{ $twoDigit->two_digit }}</td>
                    <td class="text-purple">{{ $twoDigit->pivot->sub_amount }}</td>
                    <td class="text-purple">
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
     <h5 class="text-purple">Total Morning Sub Amount: {{ number_format($totalMorningSubAmount) }}
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