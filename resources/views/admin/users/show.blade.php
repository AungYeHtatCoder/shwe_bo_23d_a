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


.custom-form-group {
 margin-bottom: 20px;
}

.custom-form-group label {
 display: block;
 margin-bottom: 5px;
 font-weight: bold;
 color: #555;
}

.custom-form-group input,
.custom-form-group select {
 width: 100%;
 padding: 10px 15px;
 border: 1px solid #e1e1e1;
 border-radius: 5px;
 font-size: 16px;
 color: #333;
}

.custom-form-group input:focus,
.custom-form-group select:focus {
 border-color: #d33a9e;
 box-shadow: 0 0 5px rgba(211, 58, 158, 0.5);
}

.submit-btn {
 background-color: #d33a9e;
 color: white;
 border: none;
 padding: 12px 20px;
 border-radius: 5px;
 cursor: pointer;
 font-size: 18px;
 font-weight: bold;
}

.submit-btn:hover {
 background-color: #b8328b;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/material-icons@1.13.12/iconfont/material-icons.min.css">
@endsection
@section('content')
<div class="row justify-content-center">
 <div class="col-md-12">
  <div class="container mt-2">
   <div class="d-flex justify-content-between">
    <h4>User Detail</h4>
    <a class="btn btn-icon btn-2 btn-primary" href="{{ route('admin.users.index') }}">
     <span class="btn-inner--icon mt-1"><i class="material-icons">arrow_back</i>Back</span>
    </a>
   </div>
   <div class="card">
    <div class="table-responsive">
     <table class="table align-items-center mb-0">
      <tbody>
        <tr>
          <th>Profile</th>
          <td>
            <div class="card-header mx-4 p-3 text-center">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ Auth::user()->profile }}" alt="bruce" class="w-100 rounded-circle shadow-sm">
                        </div>
                    </div>
          </td>
        </tr>
       <tr>

        <th>ID</th>
        <td>{!! $user_detail->id !!}</td>
       </tr>
       <tr>
        <th>User Name</th>
        <td>{!! $user_detail->name !!}</td>
        <td id="password">
         <form action="{{ route('admin.password-reset', ['id' => $user_detail->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
        <div class="card-body pt-0">
            <div class="input-group input-group-outline my-4">
                <label class="form-label">New password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="input-group input-group-outline my-4">
              <input type="password" name="password_confirmation" class="form-control" required placeholder="Enter Confirm password">
          </div>
            
            <h5 class="mt-3">Password requirements</h5>
            <p class="text-muted mb-2">
                Please follow this guide for a strong password:
            </p>
            <ul class="text-muted ps-4 mb-0 float-start">
                <li>
                    <span class="text-sm">One special characters</span>
                </li>
                <li>
                    <span class="text-sm">Min 6 characters</span>
                </li>
                <li>
                    <span class="text-sm">One number (2 are recommended)</span>
                </li>
                <li>
                    <span class="text-sm">Change it often</span>
                </li>
            </ul>
            <button type="submit" class="btn bg-gradient-dark btn-sm float-end mb-0">PasswordReset</button>
        </div>
        </form>
        </td>
       </tr>
       <tr>
        <th>Phone</th>
        <td>{!! $user_detail->phone !!}</td>
       </tr>
       <tr>
        <th>2D Commission</th>
        <td>{!! $user_detail->cor !!}</td>
        <td>
          <form method="POST" action="{{ route('admin.updateCor', ['id' => $user_detail->id]) }}">
                @csrf
                @method('PATCH')
               <div class="input-group input-group-outline my-4">
                <input type="text" name="cor" placeholder="Enter 2D Commission Amount" required class="form-control">
               </div>
                <button type="submit" class="btn bg-gradient-dark btn-sm float-end mb-0">Update2DCommission</button>
            </form>
        </td>
       </tr>
       <tr>
        <th>3D Commission</th>
        <td>{!! $user_detail->cor3 !!}</td>
        <td>
          <form method="POST" action="{{ route('admin.updateCor3', ['id' => $user_detail->id]) }}">
                @csrf
                @method('PATCH')
               <div class="input-group input-group-outline my-4">
                <input type="text" name="cor3" placeholder="Enter 3D Commission Amount" required class="form-control">
               </div>
                <button type="submit" class="btn bg-gradient-dark btn-sm float-end mb-0">Update3DCommission</button>
            </form>
        </td>
       </tr>
       <tr>
        <th>2D Limit</th>
        <td>{!! $user_detail->limit !!}</td>
        <td>
          <form method="POST" action="{{ route('admin.updatelimit', ['id' => $user_detail->id]) }}">
                @csrf
                @method('PATCH')
               <div class="input-group input-group-outline my-4">
                <input type="text" name="limit" placeholder="Enter 2D Limit Amount" required class="form-control">
               </div>
                <button type="submit" class="btn bg-gradient-dark btn-sm float-end mb-0">Update2DLimit</button>
            </form>
        </td>
       </tr>
       <tr>
        <th>3D Limit</th>
        <td>{!! $user_detail->limit !!}</td>
        <td>
          <form method="POST" action="{{ route('admin.threeDupdatelimit', ['id' => $user_detail->id]) }}">
                @csrf
                @method('PATCH')
               <div class="input-group input-group-outline my-4">
                <input type="text" name="limit3" placeholder="Enter 3D Limit Amount" required class="form-control">
               </div>
                <button type="submit" class="btn bg-gradient-dark btn-sm float-end mb-0">Update3DLimit</button>
            </form>
        </td>
       </tr>
       <tr>
        <th>Gem</th>
        <td>{!! $user_detail->gem !!}</td>
       </tr>
       <tr>
        <th>Bonu</th>
        <td>{!! $user_detail->bonus !!}</td>
       </tr>
       <tr>
        <th>Winning Prize</th>
        <td>{!! $user_detail->prize_balance !!}</td>
       </tr>
       <tr>
        <th>Create Date</th>
        <td>{!! $user_detail->created_at !!}</td>
       </tr>
       <tr>
        <th>Update Date</th>
        <td>{!! $user_detail->updated_at !!}</td>
       </tr>
      </tbody>
     </table>
    </div>
   </div>
  </div>
 </div>
</div>


@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

<script src="{{ asset('admin_app/assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('admin_app/assets/js/plugins/quill.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
if (document.getElementById('choices-tags-edit')) {
 var tags = document.getElementById('choices-tags-edit');
 const examples = new Choices(tags, {
  removeItemButton: true
 });
}
</script>
<script>
if (document.getElementById('choices-roles')) {
 var role = document.getElementById('choices-roles');
 const examples = new Choices(role, {
  removeItemButton: true
 });

 examples.setChoices(
  [{
    value: 'One',
    label: 'Expired',
    disabled: true
   },
   {
    value: 'Two',
    label: 'Out of Role',
    selected: true
   }
  ],
  'value',
  'label',
  false,
 );
}
// store role
$(document).ready(function() {
 $('#submitForm').click(function(e) {
  e.preventDefault();

  $.ajax({
   type: "POST",
   url: "{{ route('admin.roles.store') }}",
   data: $('form').serialize(),
   success: function(response) {
    Swal.fire({
     icon: 'success',
     title: 'Role created successfully',
     showConfirmButton: false,
     timer: 1500
    });
    // Reset the form after successful submission
    $('form')[0].reset();
   },
   error: function(error) {
    console.log(error);
    Swal.fire({
     icon: 'error',
     title: 'Oops...',
     text: 'Something went wrong!'
    });
   }
  });
 });
});
</script>
@endsection