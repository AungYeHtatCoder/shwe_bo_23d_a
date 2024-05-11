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
      <h5 class="mb-0">2D Opening Date & Time Dashboards</h5>
      {{-- <p class="text-sm mb-0">
                    A lightweight, extendable, dependency-free javascript HTML table plugin.
                  </p> --}}
     </div>
     <div class="ms-auto my-auto mt-lg-0 mt-4">
      <div class="ms-auto my-auto">
       {{-- <a href="" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; New Product</a> --}}
       {{-- <button type="button" class="btn btn-outline-primary btn-sm mb-0 py-2" data-bs-toggle="modal"
        data-bs-target="#import">
        +&nbsp; Update Permission
       </button> --}}
      
       <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1 py-2" data-type="csv" type="button"
        name="button">Export</button>
      </div>
     </div>
    </div>
   </div>
   <div class="table-responsive">
    <table class="table table-flush" id="permission-search">
     <thead class="thead-light">
      <tr>
       <th>#</th>
       <th>OpeningDate</th>
       <th>OpeningTime</th>
       <th>ResultNumber</th>
       <th>PrizeNumber</th>
       <th>Status</th>
       <th>Session</th>
       <th>Update</th>
       
      </tr>
     </thead>
     <tbody>
      @foreach($results as $key => $result)
      <tr>
       <td class="text-sm font-weight-normal">{{ ++$key }}</td>
       <td class="text-sm font-weight-normal">{{ $result->result_date }}</td>
       <td class="text-sm font-weight-normal">{{ $result->result_time }}</td>
       <td class="text-sm font-weight-normal">{{ $result->result_number ?? 'Pending' }}</td>
       <td>
            <form method="POST" action="{{ route('admin.update_result_number', ['id' => $result->id]) }}">
                @csrf
                @method('PATCH')
                <input type="text" name="result_number" placeholder="Enter result number" required class="form-control">
                <button type="submit" class="btn btn-primary">CreatePrizeNumber</button>
            </form>
        </td>
       <td id="status-{{ $result->id }}">{{ ucfirst($result->status) }}</td>
        <td>{{ ucfirst($result->session) }}</td>
        <td>
            <!-- Toggle button to update status -->
            <button class="toggle-status"
                    data-id="{{ $result->id }}"
                    data-status="{{ $result->status == 'open' ? 'closed' : 'open' }}">
                Open/Close
            </button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Include CSRF token in AJAX headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.toggle-status').on('click', function() {
        const resultId = $(this).data('id'); // The ID of the result
        const newStatus = $(this).data('status'); // The new status to set

        $.ajax({
            url: '/admin/two-2-results/' + resultId + '/status', // Your route
            method: 'PATCH',
            data: {
                status: newStatus,
            },
            success: function(response) {
                alert(response.message);
                // Optional: Update the status on the page
                $('#status-' + resultId).text(newStatus);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Failed to update status.');
            }
        });
    });
});
</script>


<script>
if (document.getElementById('permission-search')) {
 const dataTableSearch = new simpleDatatables.DataTable("#permission-search", {
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