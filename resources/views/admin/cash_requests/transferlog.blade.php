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
            <h5 class="mb-0">Transfer Logs</h5>
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
      <th>Type</th>
      <th>Status</th>
      <th>Transfered By</th>
      <th>Created_at</th>
      {{-- <th>Action</th>  --}}
     </thead>
     <tbody>
      @foreach ($logs as $log)
      <tr>
            <td>{{ $loop->iteration }}</td>
                <td>
                <span class="d-block">{{ $log->user->name }}</span>
                </td>
            <td>{{ $log->user->phone }}</td>
            <td>{{ number_format($log->amount)." ".$log->currency }}</td>
            <td>{{ $log->type }}</td>
            <td>
                <span class="badge badge-{{ $log->status == 0 ? "warning" : ($log->status == 1 ? "success" : ($log->status == 2 ? "danger" : "")) }}">
                  {{ $log->status == 0 ? "pending" : ($log->status == 1 ? "accepted" : ($log->status == 2 ? "rejected" : "")) }}
                </span>
            </td>      
            <td>{{ $log->createdBy->name ?? "" }}</td>
            <td>{{ $log->created_at->format('d-m-Y') }}</td>
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