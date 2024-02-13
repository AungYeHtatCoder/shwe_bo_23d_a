@extends('user_layouts.master')

@section('style')

@endsection

@section('content')
@include('user_layouts.navbar')

<!-- content -->
@if ($lottery_matches->is_active == 1)
<form action="{{ route('user.twod-play-index-12pm.store') }}" method="POST" class="pt-5 mt-5">
@csrf
<div class="row">
    <div class=""
      style="padding-bottom:100px;">
    <div>
      <h6 class="m-3 text-center text-white">ထိုးမည့်ဂဏန်းများ</h6>
      <table class="table text-center">
       <tbody id="digit_data">
        <tr>
         <th>စဉ်</th>
         <th>ဂဏန်း</th>
         <th>ငွေပမာဏ</th>
         <th>ပြင် / ဖျက်</th>
        </tr>

       </tbody>
      </table>
        <div class="col-md-12 mb-3">
            <label for="totalAmount">Total Amount</label>
            <input type="text" id="totalAmount" name="totalAmount" class="form-control" readonly>
        </div>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="d-flex justify-content-between">
            <div>
                <p class="pt-2">လက်ကျန်ငွေ</p>
                <p id="userBalance" data-balance="{{ Auth::user()->balance }}">{{ Auth::user()->balance }} MMK</p>
            </div>
            <div class="" >
                {{-- <button class="btn btn-sm btn-danger me-2" style="font-size: 14px;" onclick="confirmPlay()">ဖျက်မည်</button> --}}
                <a onclick="confirmPlay()" href="{{ route('user.twod-play-index-12pm') }}" class="btn btn-sm btn-danger me-2" style="font-size: 14px;">ဖျက်မည်</a>
                <button type="submit" class="btn btn-sm btn-purple text-white me-1" style="font-size: 14px;">ထိုးမည်</button>
              </div>
        </div>
     </div>
    </div>
</div>
</form>
@else
<div class="text-center p-4">
    <h3>Sorry, you can't play now. Please wait for the next round.</h3>
</div>
@endif
<!-- Bootstrap Modal -->
<div class="modal fade" id="editAmountModal" tabindex="-1" aria-labelledby="editAmountModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAmountModalLabel">Edit Amount</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editAmountForm">
          <div class="mb-3">
            <label for="editDigitAmount" class="col-form-label text-purple">Digit:</label>
            <input type="text" class="form-control" id="editDigit" readonly>
          </div>
          <div class="mb-3">
            <label for="editDigitAmount" class="col-form-label text-purple">Amount:</label>
            <input type="number" class="form-control" id="editDigitAmount">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveEdit()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- content -->


@include('user_layouts.footer')
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    @if(session('SuccessRequest'))
    Swal.fire({
      icon: 'success',
      title: 'Success! သင့်ကံစမ်းမှုအောင်မြင်ပါသည် ! သိန်းထီးဆုကြီးပေါက်ပါစေ',
      text: '{{ session('
      SuccessRequest ') }}',
      timer: 3000,
      showConfirmButton: false
    });
    @endif
  });
</script>
<script>
  function showLimitFullAlert() {
    Swal.fire({
      icon: 'info',
      title: 'Limit Reached',
      text: 'This two digit\'s amount limit is full.'
    });
  }

// Function to display the data from local storage
function displayLocalStorageData() {
  const selections = JSON.parse(localStorage.getItem('twoDigitSelections')) || {};
  const tbody = document.getElementById('digit_data');
  const selectedDigitsInput = document.createElement('input');
  selectedDigitsInput.setAttribute('type', 'hidden');
  selectedDigitsInput.setAttribute('name', 'selected_digits');
  selectedDigitsInput.value = Object.keys(selections).join(',');

  // Clear the current content
  tbody.innerHTML = '';

  // Append hidden input for selected digits
  tbody.appendChild(selectedDigitsInput);

  // Create table rows for each selection
  Object.entries(selections).forEach(([digit, amount], index) => {
    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td>${index + 1}</td>
      <td>
        <span class="digit-display">${digit}</span>
      </td>
      <td>
        <input type="text" name="amounts[${digit}]" class="form-control" value="${amount}" readonly>
      </td>
      <td>
        <div class="d-flex justify-content-center">
          <a href="#" onclick="editDigit('${digit}'); return false;"><i class="fa-regular fa-pen-to-square mx-3"></i></a>
          <a href="#" onclick="removeDigit('${digit}'); return false;"><i class="fa-regular fa-trash-can text-danger"></i></a>
        </div>
      </td>
    `;

    tbody.appendChild(tr);
  });

  // Update the total amount
  updateTotalAmount();
}


// Call displayLocalStorageData on page load or when needed
displayLocalStorageData();

function editDigit(digit) {
  // Get the existing amount from the selections
  const selections = JSON.parse(localStorage.getItem('twoDigitSelections')) || {};
  const currentAmount = selections[digit] || 0; // Default to 0 if not found

  // Set the digit and amount in the modal fields
  document.getElementById('editDigit').value = digit;
  document.getElementById('editDigitAmount').value = currentAmount;

  // Display the modal
  var myModal = new bootstrap.Modal(document.getElementById('editAmountModal'), {
    keyboard: false
  });
  myModal.show();
}

// Function to save the edited amount from the modal
function saveEdit() {
  // Get the digit and new amount from the modal fields
  const digit = document.getElementById('editDigit').value;
  const newAmount = document.getElementById('editDigitAmount').value;

  const selections = JSON.parse(localStorage.getItem('twoDigitSelections')) || {};
  if (newAmount && newAmount !== selections[digit]) {
    // Update the selections with the new amount
    selections[digit] = newAmount;
    localStorage.setItem('twoDigitSelections', JSON.stringify(selections));

    // Update the display
    displayLocalStorageData();
    updateTotalAmount();
  }

  // Hide the modal
  var myModalEl = document.getElementById('editAmountModal');
  var modal = bootstrap.Modal.getInstance(myModalEl);
  modal.hide();
}


function removeDigit(digit) {
  console.log('Removing digit', digit);
  let selections = JSON.parse(localStorage.getItem('twoDigitSelections')) || {};
  // If the digit is found in the selections, update the balance and remove it
  if (digit in selections) {
    updateBalance(parseInt(selections[digit], 10), 'add');
    delete selections[digit];
  }
  localStorage.setItem('twoDigitSelections', JSON.stringify(selections));
  displayLocalStorageData();
  updateTotalAmount();
  location.reload(); // Refresh the entire page
}

function updateTotalAmount() {
  let total = 0;
  const inputs = document.querySelectorAll('input[name^="amounts["]');
  inputs.forEach(input => {
    total += Number(input.value);
  });

  const userBalanceSpan = document.getElementById('userBalance');
  let userBalance = Number(userBalanceSpan.getAttribute('data-balance'));

  if (userBalance < total) {
    //alert('Your balance is not enough to play two digit.');
    Swal.fire({
     icon: 'error',
        title: 'Oops...',
        text: 'Your balance is not enough to play two digit. - သင်၏လက်ကျန်ငွေ မလုံလောက်ပါ - ကျေးဇူးပြု၍ ငွေဖြည့်ပါ။',
        footer: `<a href=
         "{{ url('user/wallet-deposite') }}" style="background-color: #007BFF; color: #FFFFFF; padding: 5px 10px; border-radius: 5px; text-decoration: none;">Fill Balance - ငွေဖြည့်သွင်းရန် နိုပ်ပါ </a>`
    });
    return;
  }

  userBalance -= total;
  userBalanceSpan.textContent = userBalance.toFixed(2);
  userBalanceSpan.setAttribute('data-balance', userBalance.toFixed(2));
  document.getElementById('totalAmount').value = total.toFixed(2);
}

// Function to update the balance when adding or subtracting
function updateBalance(amount, operation) {
  const userBalanceSpan = document.getElementById('userBalance');
  let userBalance = Number(userBalanceSpan.getAttribute('data-balance'));

  if (operation === 'add') {
    userBalance += amount;
  } else if (operation === 'subtract') {
    userBalance -= amount;
  }

  userBalanceSpan.textContent = userBalance.toFixed(2);
  userBalanceSpan.setAttribute('data-balance', userBalance.toFixed(2));
}

function confirmPlay() {
  // Clear the local storage
  localStorage.removeItem('twoDigitSelections');

  // You can call `updateTotalAmount` if needed or redirect the user after this
  // For example:
  //window.location.href = 'path_to_redirect_after_confirmation';
}

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // prevent the form from submitting immediately

    Swal.fire({
      title: 'Are you sure- ထိုးမှာလား ?',
      text: 'You are about to submit your lottery choices.',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'No, cancel! - မထိုးပါ!',
      confirmButtonText: 'Yes, submit it! - ထိုးမယ်!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicked "Yes", submit the form
         confirmPlay();
        event.target.submit();
      }
    });
  });

</script>

@endsection

