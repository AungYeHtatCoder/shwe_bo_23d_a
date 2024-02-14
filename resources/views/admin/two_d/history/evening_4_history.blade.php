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
      <h5 class="mb-0">4:30 PM - History Dashboards</h5>

     </div>
     <div class="ms-auto my-auto mt-lg-0 mt-4">
      <div class="ms-auto my-auto">
       {{-- <a href="{{ route('admin.users.create') }}" class="btn bg-gradient-primary btn-sm mb-0 py-2">+&nbsp; Create New
        User</a> --}}
       <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1 " data-type="csv" type="button"
        name="button">Export</button>
      </div>
     </div>
    </div>
   </div>
   <div class="table-responsive">
    <table class="table table-flush text-center" id="users-search">
     <thead class="thead-light">
      <th>#</th>
       <th>User</th>
       <th>Match</th>
       <th>Two-Digit</th>
       <th>Sub Amount</th>
       <th>Prize Sent</th>
       <th>Session</th>
       <th>Time</th>
     </thead>
     <tbody class="text-start">
       @forelse ($twoDigitData as $lottery)
                @foreach ($lottery->twoDigits as $twoDigit)
                    <tr>
                        <td>{{ $loop->parent->index + 1 }}</td>
                        <td>{{ $lottery->user->name }}</td>
                        <td>{{ $lottery->lotteryMatch->match_name }}</td>
                        <td>{{ $twoDigit->two_digit }}</td>
                        <td>{{ $twoDigit->pivot->sub_amount }}</td>
                        <td>{{ $twoDigit->pivot->prize_sent ? 'Yes' : 'No' }}</td>
                        <td>{{ $lottery->session }}</td>
                        <td>{{ $twoDigit->pivot->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8">No data available.</td>
                </tr>
            @endforelse
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