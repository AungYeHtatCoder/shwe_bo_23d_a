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
      <h5 class="mb-0">2D Morning Section History Dashboards</h5>
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
     <thead>
                <tr>
                    <th>#</th>
                    <th>Account ID</th>
                    <th>User Name</th>
                    <th>Session</th>
                    <th>ResultDate</th>
                    <th>ResultTime</th>
                    <th>Bet Digit</th>
                    <th>Sub Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $key => $result)
                    <tr>
                        <td>{{ $key+1 }} </td>
                        <td>{{ $result->user_id }}</td>
                        <td>{{ $result->user_name }}
                        <td> {{ $result->session}}</td>
                        <td>{{ $result->res_date }}</td>
                        <td>{{ $result->res_time }}</td>
                        <td>{{ $result->bet_digit }}</td>
                        <td>{{ $result->sub_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
    </table>
   </div>
  </div>
  <div class="card mt-4">
        <div class="card-header">
            <p class="text-center">Total Sub Amount for Morning Session:</p>
        </div>
        <div class="card-body">
        <p class="text-center"> {{ $totalSubAmount }}</p>

        </div>
    </div>
 </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('admin_app/assets/js/plugins/datatables.js') }}"></script>


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