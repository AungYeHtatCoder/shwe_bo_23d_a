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
  .icon{
    font-size: 25px;
    cursor: pointer;
  }
  .input{
    border: 1px solid #a6a6a6;
    padding-left: 10px;
  }
</style>
@endsection
@section('content')
<div class="row mb-3">
  <div class="col-12">
    <div class="card py-4 px-3">
      <!-- Card header -->
      <h5 class="mb-0">Cash In Request Detail</h5>
      <div class="table-responsive">
        <table class="table">
            <tr>
                <th>User Name</th>
                <td>{{ $cash->user->name }}</td>
            </tr>
            <tr>
                <th>User Balance (MMK)</th>
                <td>{{ number_format($cash->user->balance) }} MMK</td>
            </tr>
            <tr>
              @php
                $rate = App\Models\Admin\Currency::latest()->first()->rate;
              @endphp
                <th>User Balance (BHT)</th>
                <td>{{ number_format($cash->user->balance/$rate) }} BHT</td>
            </tr>
            <tr>
                <th>ငွေလွှဲသူဖုန်း</th>
                <td>{{ $cash->phone }}</td>
            </tr>
            <tr>
                <th>ငွေလွှဲသူအမည်</th>
                <td>{{ $cash->name }}</td>
            </tr>
            <tr>
                <th>ငွေလွှဲပမာဏ</th>
                <td>{{ number_format($cash->amount)." ".$cash->currency }}</td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td>{{ $cash->payment_method }}</td>
            </tr>
            <tr>
                <th>နောက်ဆုံးဂဏန်း၆လုံး</th>
                <td>{{ $cash->last_6_num }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <i onclick="document.getElementById('status').submit()" class="fas icon text-{{ $cash->status == 1 ? 'success' : 'danger' }} fa-toggle-{{ $cash->status == 1 ? 'on' : 'off' }}"></i>   
                    <form id="status" action="{{ url('/admin/cashIn/status/'.$cash->id) }}" class="d-none" method="POST">
                      @csrf
                    </form>               
                </td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>
                    {{ $cash->created_at->format('d-m-Y') }}
                </td>
            </tr>
            {{-- <tr>
              <th>Actions</th>
              <td><a href="" class="btn btn-sm btn-warning"><i class="fas fa-coins me-2"></i>ငွေလွှဲရန်</a></td>
            </tr> --}}
        </table>
      </div>
      <form action="{{ url('/admin/transfer/'.$cash->user_id) }}" method="post">
        @csrf
        <div class="row">
          <div class="col-md-8">
            <label for="balance" class="form-label">
              ငွေလွှဲပမာဏ
              <label for="mmk" class="form-label ms-3">
                <input type="radio" name="currency" id="mmk" value="kyat">
                ကျပ်
              </label>
              <label for="bht" class="form-label ms-3">
                <input type="radio" name="currency" id="bht" value="baht">
                ဘတ်
              </label>
            </label>
            <input type="number" placeholder="Enter Amount" class="form-control input" name="amount" id="balance">
          </div>
          @error('amount')
            <span class="text-danger">*{{ $message }}</span>
          @enderror
          @error('currency')
            <span class="text-danger">*{{ $message }}</span>
          @enderror

          <div class="mt-3">
            <button class="btn btn-warning">ငွေလွှဲသည်</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('admin_app/assets/js/plugins/datatables.js') }}"></script>
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