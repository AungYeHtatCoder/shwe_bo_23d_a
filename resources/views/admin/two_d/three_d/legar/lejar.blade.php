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
         #twoD{
        width:100%;
        height: 400px;
        overflow: scroll;
    }
    .twoDCard{
        display: grid;
        grid-template-columns: auto auto auto auto auto;
        grid-gap: 10px;
    }
    .number-card{
        width: 100%;
        height: 100%;
    }
    .n-row{
        width: 100%;
        height: 100%;
        text-align: center;
        color: brown;
    
    }
    .n-row:nth-child(odd){
        background-color: #b00e8a;
        color: white;
    }
    .n-row:nth-child(even){
        background-color: #e6e6e6;
        color: rgb(49, 17, 230);
    }
    .col-tr{
        background-color: #4c0c95;
        color: white;
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
td{
    padding: 0 !important;
    margin:0 !important;
    height: auto;
    align-items: center;
    justify-items: center;
    align-self: center;
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
                            <h5 class="mb-0">3D လယ်ဂျာ ပေါင်းချုပ် စာရင်း  
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
                  <div class="container mb-5 mt-3" id="twoD">
               <div class="twoDCard">
             <table class="table table-bordered">
    <thead style="background-color: #910503; color: #fff;">
    <tr>
        @for ($i = 0; $i < 20; $i+=2)
            <th class="px-3 m-0 text-center">N</th>
            <th class="px-1 m-0 text-center"> Amount</th>
            {{-- <th class="px-1 m-0 text-center">Evening Amount</th> --}}
        @endfor
    </tr>
    </thead>
    <tbody>
    @foreach(array_chunk($data, 10, true) as $chunk)
        <tr class="m-0 p-0">
            @foreach($chunk as $three_digit => $sessions)
                <td class="text-dark text-center" style="background-color: #fda6a5">{{ $three_digit }}</td>
                <td class="text-center">
                    @if(isset($sessions['data']->total_sub_amount))
                        {{ $sessions['data']->total_sub_amount }}
                    @else
                        <p>-</p>
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

               </div>
             </div>
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
            url: "/admin/two-d-commission-update/" + userId, // Update with your actual path
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
