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
                            <h5 class="mb-0">3D ပေါက်သူများစာရင်း Dashboards
                                <span>
                                    {{-- <button type="button" class="btn btn-primary mt-2 ms-2">
                                        @if ($prize_no_morning)
                                            <span>{{ $prize_no->created_at->format('d-m-Y (l) (h:i a)') }}</span>
                                            <span class="badge badge-warning"
                                                style="font-size: 15px; color:white">{{ $prize_no->prize_no }}</span>
                                        @else
                                            <span>No Prize Number Yet</span>
                                        @endif
                                    </button> --}}
                                </span>
                            </h5>

                        </div>
                        <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <div class="ms-auto my-auto">
                                {{-- <a href="{{ route('admin.users.create') }}"
                                    class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Create New
                                    User</a> --}}
                                <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv"
                                    type="button" name="button">Export</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    @php 
                    $totalPrizeAmount = 0; // Initialize the variable here
                    @endphp
                    @if($winners->isEmpty())
   <p style="color: #f5bd02">No winners found for the past month.</p>
   @else
   <table class="table table-flush" id="users-search">
    
    @foreach($winners as $index => $winner)
    <tr>
     {{-- <td class="mt-2">1.</td> --}}
     <td>
      {{ $index + 1 }}
     </td>
     <td>
      @if($winner->profile)
      <img src="{{ $winner->profile }}" width="50px" height="50px" style="border-radius: 50%" alt="" />
      @else
      <i class="fa-regular fa-circle-user" style="font-size: 50px;"></i>
      @endif
     </td>
     <td><span style="font-size: 10px">{{ $winner->name }}</span>
      <p style="font-size: 10px">{{ $winner->phone }}</p>
     </td>
     {{-- <td><span>Session</span>
            <p>{{ ucfirst($winner->session) }}</p>
     </td> --}}
     <td><span>ပေါက်ဂဏန်း</span>
      <p class="text-primary">{{ $winner->prize_no }}</p>
     </td>
     <td><span>ထိုးငွေ</span>
      <p>{{ $winner->sub_amount }}</p>
     </td>
     <td><span>ထီပေါက်ငွေ</span>
      <p class="text-primary">{{ $winner->prize_amount }}</p>
     </td>
    
     <td>
      <span>ရက်စွဲ</span>
      <p>
       {{-- date with format --}}
       {{ \Carbon\Carbon::parse($winner->created_at)->format('d-m-Y (l) (h:i a)') }}
      </p>
     </td>
     {{-- <td>
        @if($winner->prize_sent == 1)
            <span>
                <p class="text-primary">
                    လျော်ပြီး
                </p>
            </span>
        @else
            <span>
                <p class="text-primary">
                    မလျော်ရသေးပါ
                </p>
            </span> 
        @endif

     </td> --}}
    </tr>
    @php 
    $totalPrizeAmount += $winner->prize_amount;
    @endphp
    @endforeach

   </table>
   @endif
                </div>
            </div>
        <div class="mt-4">
        <div class="card">
            <div class="card-header">
                <p class="mb-0 text-center">
            <span style="font-size: 20px">ထီပေါက်ငွေစုစုပေါင်း</span>
            <span style="font-size: 20px" class="text-primary">{{ $totalPrizeAmount }}</span>
        </p>
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
        if (document.getElementById('users-search')) {
            const dataTableSearch = new simpleDatatables.DataTable("#users-search", {
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
                        data.columnDelimiter = "|";
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
