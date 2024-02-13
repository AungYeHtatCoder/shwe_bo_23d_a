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
      <h5 class="mb-0">User Dashboards</h5>

     </div>
     <div class="ms-auto my-auto mt-lg-0 mt-4">
      <div class="ms-auto my-auto">
       <a href="{{ route('admin.users.create') }}" class="btn bg-gradient-primary btn-sm mb-0 py-2">+&nbsp; Create New
        User</a>
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
      <th>UserName</th>
      <th>Phone</th>
      <th>Status</th>
      <th>Created_at</th>
      <th>Action</th>
     </thead>
     <tbody class="text-start">
      @foreach ($users as $key => $user)
      <tr>
        <td class="text-sm font-weight-normal">{{ ++$key }}</td>
        <td class="text-sm font-weight-normal">
          <span class="d-block mb-2">{{ $user->name }}</span>
          @foreach ($user->roles as $role)
          <span class="badge badge-info">
          {{ $role->title }}
          </span>
          <br>
          @endforeach
        </td>
        <td class="text-sm font-weight-normal">{{ $user->phone }}</td>
        <td class="text-sm font-weight-normal">
          <span class="badge badge-{{ $user->status == 0 ? 'success' : 'danger' }}">{{ $user->status == 0 ? "active" : "ban" }}</span>
        </td>
        <td class="text-sm font-weight-normal">{{ $user->created_at->format('F j, Y') }}</td>
        <td>
          @if ($user->status == 0)
              <a onclick="event.preventDefault(); document.getElementById('banUser-{{ $user->id }}').submit();" class="me-2" href="#" data-bs-toggle="tooltip" data-bs-original-title="Ban User">
                  <i class="fas fa-user-slash text-danger" style="font-size: 20px;"></i>
              </a>
          @else
              <a onclick="event.preventDefault(); document.getElementById('banUser-{{ $user->id }}').submit();" class="me-2" href="#" data-bs-toggle="tooltip" data-bs-original-title="Active User">
                  <i class="fas fa-user-check text-success" style="font-size: 20px;"></i>
              </a>
          @endif
          
          <form class="d-none" id="banUser-{{ $user->id }}" action="{{ route('admin.users.ban', $user->id) }}" method="post">
              @csrf
              @method('PUT')
          </form>
      

          <a class="me-1" href="{{ route('admin.users.edit', $user->id) }}" data-bs-toggle="tooltip"
          data-bs-original-title="Edit User">
            <i class="fas fa-pen-to-square text-info" style="font-size: 20px;"></i>
          </a>
          <a class="me-1" href="{{ route('admin.users.show', $user->id) }}" data-bs-toggle="tooltip"
          data-bs-original-title="Preview User Detail">
          <i class="fas fa-eye text-warning" style="font-size: 20px;"></i>
          </a>
          <form class="d-inline" action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="transparent-btn" data-bs-toggle="tooltip" data-bs-original-title="Delete User">
            <i class="fas fa-trash text-danger" style="font-size: 20px;"></i>
          </button>
          </form>
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