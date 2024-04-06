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

@font-face {
    font-family: 'Myanmar Pyidaungsu';
    src: url('{{ asset('assets/css/Pyidaungsu.ttf') }}') format('truetype');
    font-weight: normal;
    font-style: normal;
}

.table-font-myanmar {
    font-family: 'Pyidaungsu', sans-serif;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/material-icons@1.13.12/iconfont/material-icons.min.css">
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header pb-0">
                    <div class="d-lg-flex">
                        <div>
                            <h5 class="mb-0">အောက်နှစ်လုံး ကော်မစ်ရှင်း ပေါင်းချုပ် စာရင်း  Dashboard
                            </h5>

                        </div>
                       
                        <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <div class="ms-auto my-auto">
                                
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
                  <th>UserName</th>
                  <th>စုစုပေါင်းထိုးကြေး</th>
                  <th>ရနိုင်သောCommission</th>
                  <th>Commission</th>
                  <th>Status</th>
                  <th>ကော်မစ်ရှင်းသတ်မှတ်ရန်</th>
                  <th>update</th>
                  <th>ကော်မစ်ရှင်းပေးရန်</th>
                 </thead>
                 <tbody>
                  @foreach($totalAmounts as $index => $totalAmount)
                   <tr>
                    {{-- <td>{{ $index + 1 }}</td> --}}
                    <td>{{ $totalAmount->lottery_id }}</td>
                    <td>{{ $totalAmount->name }}</td>
                    <td>{{ $totalAmount->total_amount }}</td>
                    <td>
                         @php
                        $commission = ($totalAmount->total_amount * $totalAmount->comission) / 100;
                        @endphp
                            
                            {{ $commission }}
                    </td>
                    <td>
                        {{ $totalAmount->commission_amount }}            
                    </td> 
                    <td>
                        @if($totalAmount->status == 'pending')
                            <span class="badge badge-warning">ကော်မစ်ရှင်းမပေးရသေးပါ</span>
                        @elseif($totalAmount->status == 'approved')
                            <span class="badge badge-success">ကော်မစ်ရှင်းပေးပြီးပါပြီ</span>
                        @else
                            <span class="badge badge-danger">ကော်မစ်ရှင်းမပေးပါ</span>
                        @endif
                    </td>
                   
                    <td>
                        <input type="number" step="0.01" class="form-control commission-input border border-primary" placeholder="Enter Commission">
                        @php
                        $commission = ($totalAmount->total_amount * $totalAmount->comission) / 100;
                        @endphp
                        <input type="hidden" value="{{ $commission }}" class="commission-amount-input">
                    </td>
                    {{-- <td>
                        <button type="button" class="btn btn-primary btn-sm w-100 update-commission" data-lotto-id="{{ $totalAmount->lottery_id }}">
                            <i class="material-icons" style="font-size: 24px;">update</i>
                        </button>
                    </td> --}}
                    <td>
                    <!-- Adjust the data attribute to pass the user_id -->
                    <button type="button" class="btn btn-primary btn-sm w-100 update-commission" data-user-id="{{ $totalAmount->user_id }}">
                        <i class="material-icons" style="font-size: 24px;">update</i>
                    </button>
                    </td>
                    <td>
                    <a href="{{ route('admin.jackpot-commission-show', $totalAmount->lottery_id) }}" class="btn btn-primary btn-sm">Transfer</a>
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
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function(){
    $('.update-commission').click(function(){
        var userId = $(this).data('user-id'); // Get the user_id

        //var lottoId = $(this).data('lotto-id'); // Get the data-lotto-id attribute value
        var commissionValue = $(this).closest('tr').find('.commission-input').val(); // Get the commission value from the input field
        var commissionAmountValue = $(this).closest('tr').find('.commission-amount-input').val(); // Get the commission value from the input field
        var statusValue = 'approved';

        $.ajax({
            url: "/admin/jackpot-commission-update/" + userId, // Update with your actual path
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-HTTP-Method-Override': 'PUT' // For overriding the POST method to PUT.
            },
            data: {
                'commission': commissionValue,
                'commission_amount': commissionAmountValue,
                'status': 'approved'
            },
            success: function(response) {
                // Handle the response from the server with SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Commission updated successfully!',
                    showConfirmButton: false,
                    timer: 3000
                }).then(function() {
                    // Optional: You can refresh the page or make any UI updates here
                    location.reload(); // For instance, this would refresh the page
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle any errors with SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to update commission: ' + errorThrown,
                });
            }
        });
    });
});


</script>


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
