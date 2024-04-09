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
                            <h5 class="mb-0">2D ပေါက်သူများစာရင်းချုပ် Dashboards
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
                    @if($winners->isEmpty())
   <p style="color: #f5bd02">No winners found for the past month.</p>
   @else
   <table class="table table-flush" id="users-search">
    <thead>
     <tr>
      <th>User ID</th>
      <th>Session</th>
      <th>Name</th>
      <th>Profile</th>
      <th>Phone</th>
      <th>ထွက်ဂဏန်း</th>
      <th>ထိုးကြေး</th>
      <th>စုစုပေါင်းထိုးကြေး</th>
      <th>လျော်ငွေ</th>
      <th>Created At</th>
     </tr>
    </thead>
    <tbody>
     @foreach ($winners as $winner)
      <tr>
       <td>{{ $winner->user_id }}</td>
       <td class="text-primary">{{ $winner->session }}</td>
       <td>{{ $winner->name }}</td>
       <td>     
        @if($winner->photo)
      <img src="{{ $winner->photo }}" width="50px" height="50px" style="border-radius: 50%" alt="" />
      @else
      <i class="fa-regular fa-circle-user" style="font-size: 50px;"></i>
      @endif</td>
       <td>{{ $winner->phone }}</td>
       <td class="text-primary">{{ $winner->prize_no }}</td>
       <td class="text-primary">{{ $winner->sub_amount }}</td>
       <td>{{ $winner->total_amount }}</td>
       <td class="text-primary">{{ $winner->total_prize_amount }}</td>
       <td class="text-primary">
       {{ \Carbon\Carbon::parse($winner->created_at)->format('d-m-Y (l) (h:i a)') }}
       </td>
      </tr>
     @endforeach
    </tbody>
   </table>
   @endif

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
