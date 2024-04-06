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
                            <h5 class="mb-0">3D ကော်မစ်ရှင်း ပေါင်းချုပ် စာရင်း  Dashboard
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
                  <th>ပေးထားသောCommission</th>
                  <th>Status</th>
                 <th>TransferCommission</th>
                 </thead>
                 <tbody>
                  <tr>
                   <td>{!! $lotto->id !!}</td>
                   <td>{!! $lotto->user->name !!}</td>
                   <td>{!! $lotto->total_amount !!}</td>
                   <td>
                     @php
                        $commission = ($lotto->total_amount * $lotto->comission) / 100;
                     @endphp
                     {!! $commission !!}
                 
                   </td>
                   <td>
                        {!! $lotto->commission_amount !!}
                   </td>
                   
                   <div class="row">
                    <td>
                    <div class="col-md-6">
                      @if($lotto->status == 'pending')
                            <span class="badge badge-warning">ကော်မစ်ရှင်းမပေးရသေးပါ</span>
                        @elseif($lotto->status == 'approved')
                            <span class="badge badge-success">ကော်မစ်ရှင်းပေးပြီးပါပြီ</span>
                        @else
                            <span class="badge badge-danger">ကော်မစ်ရှင်းမပေးပါ</span>
                        @endif
                    </div>
                    </td>
                     <td>

                    <div class="col-md-6">
                    <form action="{{ route('admin.three-d-transfer-commission', $lotto->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="lotto_id" value="{{ $lotto->id }}">
                    <input type="hidden" name="commission_amount" value="{!! $lotto->commission_amount !!}">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                     <i class="material-icons" style="font-size: 10px;">update</i>TransferCommission
                    </button>
                   </form>
                    </div>
                   </td>
                   </div>
                  </tr>
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
  document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: '{{ session('success') }}', // Make sure the session key is 'success'
      timer: 3000,
      showConfirmButton: false
    });
    @endif
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
    {{-- <script>
$(document).ready(function(){
    $('.update-commission').click(function(){
        var lottoId = $(this).data('lotto-id'); // Get the data-lotto-id attribute value
        var commissionValue = $(this).closest('tr').find('input[name="commission"]').val(); // Get the commission value from the input field

        $.ajax({
            url: "{{ url('admin/three-d-commission-update') }}/" + lottoId, // Update with your actual path
            type: 'PUT',
            data: {
                '_token': '{{ csrf_token() }}',
                'commission': commissionValue,
                'lotto_id': lottoId // If your route or controller requires the lotto_id to be sent explicitly
            },
            success: function(response) {
                // Handle the response from the server
                alert('Commission updated successfully!');
                // You might want to update the UI to reflect the new commission value
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle any errors
                alert('Failed to update commission: ' + errorThrown);
            }
        });
    });
});
</script> --}}

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
