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

@font-face {
    font-family: 'Myanmar Pyidaungsu';
    src: url('{{ asset('assets/css/Pyidaungsu.ttf') }}') format('truetype');
    font-weight: normal;
    font-style: normal;
}

.table-font-myanmar {
    font-family: 'Pyidaungsu', sans-serif;
}
</style>

@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header pb-0">
                    <div class="d-lg-flex">
                        <div>
                            <h5 class="mb-0">3D တပါတ်အတွင်းထိုးထားသော စာရင်း ပေါင်းချုပ် -   Dashboards
                                <span>
                                     <h6>3D  Lottery Match Times for {{ Carbon\Carbon::now()->format('F Y') }}</h6>
                                </span>
                                <span>
                                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <div class="ms-auto my-auto">
                                
                                {{-- <a class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1"
                                    href="{{ url('/admin/three-digit-history-conclude') }}" >Back</a> --}}
                            </div>
                        </div>
                                </span>
                            </h5>

                        </div>
                       
                        <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <div class="ms-auto my-auto">
                                
                                <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv"
                                    type="button" name="button">Export</button>
                            </div>
                        </div>
                    </div>
                </div>
   <div class="table-responsive">
   
       <table class="table table-flush" id="twod-search">
           <thead class="thead-light">
                <tr>
                <th>No</th>
                <th>UserName</th>
                <th>3D</th>
                <th>ထိုးကြေး</th>
                <th>ရက်စွဲ</th>
                <th>OpenDate</th>
                <th>Win/Lose</th>
                </tr>
           </thead>
            <tbody>
        @if(isset($displayThreeDigits['jackpotDigit']) && count($displayThreeDigits['jackpotDigit']) == 0)
        <p class="text-center text-white px-3 py-2 mt-3" style="background-color: #c50408">
          ကံစမ်းထားသော 3D ထီဂဏန်းများ မရှိသေးပါ
        </p>
        @endif

        @if($displayThreeDigits)
        @foreach ($displayThreeDigits as $index => $digit)
        <tr>
          <td>{{ $index + 1 }}</td>
            <td>{{ $digit->user_name }}</td>
          <td>{{ $digit->bet_digit }}</td>
          <td>
           @if($digit->sub_amount >= $three_limits->three_d_limit)
           <span class="text-danger">
            {{ $digit->sub_amount }}
           </span>
           @else
           <p class="text-info">
            {{ $digit->sub_amount }}
           </p>
           @endif
          </td>
          {{-- <td class="text-sm font-weight-normal">

                 <span class="badge bg-gradient-info">
                    {{ $digit->created_at->timezone('Asia/Yangon')->format('d-m-Y (l) (h:i a)') }}
                </span>
             </td> --}}
             <td class="text-sm font-weight-normal">
                <span class="badge bg-gradient-info">
                    @if($digit->created_at)
                        {{ $digit->created_at->timezone('Asia/Yangon')->format('d-m-Y (l) (h:i a)') }}
                    @else
                        N/A
                    @endif
                </span>
            </td>
            <td>
                {{ $digit->res_date }}
            </td>
            
             <td>
                 @if ($digit->prize_sent == 1)
                     <span class="text-success">Win</span>
                @elseif($digit->prize_sent == 2)
                     <span class="text-danger">ပါတ်လယ်</span>
                 @else
                     <span class="text-danger">Pending</span>
                 @endif
             </td>
        </tr>
        @endforeach
        @endif
      </tbody>
       </table>
        <div class="mb-3 d-flex justify-content-around text-white p-2 shadow border border-1" style="border-radius: 10px; background: var(--Primary, #12486b)">
      <p class="text-end pt-1" style="color: #fff">Total Amount : ||&nbsp; &nbsp; စုစုပေါင်းထိုးကြေး
        <strong>{{ $totalSubAmount }} MMK</strong>
      </p>
    </div>
   </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin_app/assets/js/plugins/datatables.js') }}"></script>
    {{-- <script>
    const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
      searchable: true,
      fixedHeight: true
    });
  </script> --}}
    <script>
        if (document.getElementById('twod-search')) {
            const dataTableSearch = new simpleDatatables.DataTable("#twod-search", {
                searchable: true,
                fixedHeight: false,
                perPage: 7
            });

            document.querySelectorAll(".export").forEach(function(el) {
                el.addEventListener("click", function(e) {
                    var type = el.dataset.type;

                    var data = {
                        type: type,
                        filename: "material-" + type,
                    };

                    if (type === "csv") {
                        data.columnDelimiter = ",";
                    }

                    dataTableSearch.export(data);
                });
            });
        };
    </script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
