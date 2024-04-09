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
                            <h5 class="mb-0">3D History Dashboards
                                <span>
                                     <h6>Thai 3D Lottery Match Times for {{ Carbon\Carbon::now()->format('F Y') }}</h6>
                                </span>
                            </h5>

                        </div>
                        <div class="card-header">
                         <div class="d-lg-flex">
                          {{-- <div>
                            @php 
                            if ($matchTime) {
                            // Assuming the format is "Number: Time" and you want to get the "Number" part
                            $timeParts = explode(':', $matchTime->open_time); // Split the string by the colon
                            $timeNumber = intval($timeParts[0]); // Convert the first part to an integer
                            $OpenTime = $timeNumber - 1; // Now it's safe to subtract
                        }


                            @endphp
                           
                           @if ($matchTime)
                            <p>Open Time: {{ $OpenTime }}</p>
                            <p>Match Time: {{ $matchTime->match_time }}</p>
                        @else
                            <p>No match time found for the current period.</p>
                        @endif
                          </div> --}}
                         </div>
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
       <table class="table table-flush" id="twod-search">
           <thead class="thead-light">
               <th>#</th>
               {{-- <th>Lottery ID</th> --}}
               <th>PlayerName</th>
               {{-- <th>Open</th> --}}
               <th>Three Digits</th>
               <th>Total Amount</th>
               <th>Date</th>
               <th>Action</th>
           </thead>
           <tbody>
     @foreach ($lotteries as $lottery)
         <tr>
             <td class="text-sm font-weight-normal">{{ $lottery->id }}</td>
             <td class="text-sm font-weight-normal">
                 <span class="badge badge-secondary">{{ $lottery->user->name }}</span>
             </td>
             {{-- <td class="text-sm font-weight-normal">
                 <span class="badge badge-secondary">
                   {{ optional($lottery->lotteryMatch->threedMatchTime)->match_time }} 
                  {{-- <p>Match Time: {{ $matchTime->match_time }}</p> 
                  @if ($matchTime)
                            <p>Open Time: {{ $OpenTime }}</p>
                            <p>Match Time: {{ $matchTime->match_time }}</p>
                        @else
                            <p>No match time found for the current period.</p>
                        @endif
                 </span>
             </td> --}}
             <td class="text-sm font-weight-normal">
                 <ul class="navbar-nav">
                     @foreach ($lottery->threedDigits as $threeDigit)
                         <li class="nav-item">
                             <button type="button" class="btn btn btn-primary">
                                 <span>{{ $threeDigit->three_digit }}</span>
                                 <span class="badge badge-pill badge-lg bg-gradient-success">
                                     {{ $threeDigit->pivot->sub_amount }}</span>
                             </button>
                         </li>
                     @endforeach
                 </ul>
             </td>
             <td class="text-sm font-weight-normal">
                 <button type="button" class="btn btn-success">
                     <span>{{ $lottery->total_amount }} </span>
                     {{-- <span
                         class="badge badge-sm badge-circle badge-danger border border-white border-2"></span> --}}
                 </button>
             </td>
             {{-- <td>{{ $lottery->created_at->format('d M Y (l) h:i:s A') }}</td> --}}
             <td class="text-sm font-weight-normal">

                 <span
                     class="badge bg-gradient-info">{{ $lottery->created_at->format('d-m-Y (l) (h:i a)') }}</span>
             </td>
             <td class="text-sm font-weight-normal">
                 <a href="{{ route('admin.three-d-history-show', $lottery->id )}}" class="btn btn-warning btn-sm">Show</a>
             </td>
         </tr>
     @endforeach
           </tbody>
       </table>
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
