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
            <h5 class="mb-0">Cash Out Requests</h5>
          </div>
        </div>
      </div>
        <div class="table-responsive">
          <table class="table table-flush" id="users-search">
          <thead class="thead-light">
            <th>#</th>
            <th>UserName</th>
            <th>Phone</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Status</th>
            <th>Created_at</th>
            <th>Action</th> 
          </thead>
          <tbody>
            @foreach ($cashes as $cash)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                <span class="d-block">{{ $cash->user->name }}</span>
              </td>
              <td>{{ $cash->phone }}</td>
              <td>{{ number_format($cash->amount)." ".$cash->currency }}</td>
              <td>{{ $cash->payment_method }}</td>
              <td>
                <span class="badge text-bg-{{ $cash->status == 0 ? "warning" : ($cash->status == 1 ? "success" : ($cash->status == 2 ? "danger" : "")) }} text-white mb-2">{{ $cash->status == 0 ? "pending" : ($cash->status == 1 ? "accepted" : ($cash->status == 2 ? "rejected" : "")) }}</span>
                @if($cash->status == 0)
                <div>
                  <a class="badge text-bg-success text-white" href="#" onclick="event.preventDefault(); document.getElementById('accept{{ $cash->id }}').submit();"><i class="fas fa-check"></i></a>
                  <a class="badge text-bg-danger text-white" href="#" onclick="event.preventDefault(); document.getElementById('reject{{ $cash->id }}').submit();"><i class="fas fa-trash"></i></a>
                </div>
                @endif
                
                <form id="accept{{ $cash->id }}" action="{{ url('/admin/withdraw/accept/'.$cash->id) }}" method="post" style="display: none;">
                  @csrf
                </form>
                <form id="reject{{ $cash->id }}" action="{{ url('/admin/withdraw/reject/'.$cash->id) }}" method="post" style="display: none;">
                  @csrf
                </form>
              </td>      
              <td>{{ $cash->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="card p-3">
  <h4>Cash Out </h4>
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