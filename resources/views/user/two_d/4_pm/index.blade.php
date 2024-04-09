@extends('user_layouts.master')

@section('style')
<style>
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
</style>
@endsection

@section('content')
@include('user_layouts.navbar')

<!-- content -->
<div class="container-fluid py-5 mt-5">
    <!-- Heading -->
    <div>
        <div class="d-flex justify-content-between">
            <div>
                <div>
                    <i class="fas fa-wallet me-2 text-purple"></i><span class="text-purple">Balance</span>
                    <span class="d-block text-purple" id="userBalance" data-balance="{{ Auth::user()->balance }}">{{ number_format(Auth::user()->balance) }} MMK</span>
                </div>
                <div class="mt-4">
                    <small class="d-block mb-2 text-purple">2D (04:30PM)</small>
                    <a href="{{ route('user.twod-quick-play-index') }}" class="btn btn-sm btn-purple text-white">အမြန်ရွေး</a>
                </div>
            </div>
            <div>
                <small class="d-block mb-2 text-end text-purple">
                    <i class="fas fa-clock text-white me-1 text-purple"></i>
                    ပိတ်ရန်ကျန်ချိန်
                </small>
                <small class="d-block text-end" id="todayDate text-purple"></small>
                <small class="d-block text-end" id="currentTime text-purple"></small>
                <small class="d-block text-end" id="sessionInfo text-purple"></small>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <div class="mb-3 text-end">
                <label for="" class="form-label"><small class="text-purple"><i class="fas fa-coins me-2 text-purple"></i>ထိုးကြေး</small></label>
                <div class="input-group">
                    <input type="text" name="amount" id="all_amount" class="form-control form-control-sm text-center text-purple" placeholder="ပမာဏ">
                    <button class="btn btn-sm btn-purple text-white" type="button"  id="permuteButton" onclick="permuteDigits()"><small>ပတ်လည်</small></button>
                </div>
            </div>
        </div>
        <div class="">
            @if ($lottery_matches->is_active == 1)
            <form action="" method="post" class="p-1">
             <div class="p-1">
               @csrf
               <div class="row">
                 <div class="col-md-12">
                   <label for="selected_digits" style="font-size: 14px;" class="text-purple">ရွှေးချယ်ထားသောဂဏန်းများ</label>
                   <input type="text" name="selected_digits" id="selected_digits" class="form-control form-control-sm mt-1" placeholder="Enter Digits" >
                 </div>
                <div class="col-md-12 mt-2">
                   <label for="totalAmount" style="font-size: 14px;" class="text-purple">ပတ်လည်ဂဏန်းများ</label>
                   <input type="text" id="permulated_digit" class="form-control form-control-sm" readonly>
                </div>
                <div id="amountInputs" class="col-md-12 mb-3 d-none"></div>
                <div class="col-md-12 mt-2">
                   <label for="totalAmount" style="font-size: 14px;" class="text-purple"><i class="fas fa-coins me-2 text-purple"></i>စုစုပေါင်းထိုးကြေး</label>
                   <input type="text" id="totalAmount" name="totalAmount" class="form-control form-control-sm mt-1" readonly>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-sm btn-danger me-3" type="reset">ဖျက်မည်</button>
                    <a href="{{ url('user/two-d-play-4-30-evening-confirm') }}" onclick="storeSelectionsInLocalStorage()" class="btn btn-sm btn-purple text-white" style="font-size: 14px;">ထိုးမည်</a>
                </div>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
               </div>

            </div>
            </form>
            @else
            <div class="text-center p-4">
               <h3>Sorry, you can't play now. Please wait for the next round.</h3>
            </div>
            @endif
        </div>
    </div>

    <!-- Heading -->
    <!-- 2D Numbers start -->
    <div class="container mb-5 mt-3" id="twoD">
      <div class="twoDCard">
        @foreach ($twoDigits as $digit)
        @php
        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
        ->where('two_digit_id', $digit->id)
        ->sum('sub_amount');
        @endphp

        <button type="button" class="number_card rounded-3"  onclick="selectDigit('{{ $digit->two_digit }}', this)">
          <h5>{{ $digit->two_digit }}</h5>
          <div class="progress">

            @php
            $totalAmount = 1000000;
            $betAmount = $totalBetAmountForTwoDigit; // the amount already bet
            $remainAmount = $totalAmount - $betAmount; // the amount remaining that can be bet
            $percentage = ($betAmount / $totalAmount) * 100;
            $remainPercent = 100 - $percentage;
            @endphp

            <div class="progress-bar bg-{{ $remainPercent >= 50 ? 'success' : 'warning' }}" role="progressbar" style="width: {{ $remainPercent }}%;">
                <small class="text-{{ $remainPercent >= 50 ? 'white' : 'dark' }}">{{ $remainingAmounts[$digit->id] }}</small>
            </div>

          </div>
        </button>
        @endforeach
      </div>
    </div>
</div>
<!-- content -->


@include('user_layouts.footer')
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
  // Function to update date and time display
  function updateDateTimeDisplay() {
    var d = new Date();
    document.getElementById('todayDate').textContent = d.toLocaleDateString();
    document.getElementById('currentTime').textContent = d.toLocaleTimeString();

    // Define the morning and evening session close times
    var morningClose = new Date(d.getFullYear(), d.getMonth(), d.getDate(), 12, 1);
    var eveningClose = new Date(d.getFullYear(), d.getMonth(), d.getDate(), 16, 30);

    // Determine current session based on current time
    var sessionInfo = "";
    if (d < morningClose) {
      sessionInfo = "Closes at 12:01 PM.";
    } else if (d >= morningClose && d < eveningClose) {
      sessionInfo = "Closes at 4:30 PM.";
    } else if (d >= eveningClose) {
      sessionInfo = "Evening session closed.";
    }
    document.getElementById('sessionInfo').textContent = sessionInfo;
  }

  // Update the display initially
  updateDateTimeDisplay();

  // Set interval to update the display every minute
  setInterval(updateDateTimeDisplay, 60000);
</script>
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

function selectDigit(num, element) {
    const selectedInput = document.getElementById('selected_digits');
    const amountInputsDiv = document.getElementById('amountInputs');

    // Ensure that the digits are handled as strings
    let selectedDigits = selectedInput.value ? selectedInput.value.split(",") : [];
    num = num.toString(); // Convert num to a string to ensure "00" is not treated as 0

    // Check if the digit is already selected
    if (selectedDigits.includes(num)) {
        // If it is, remove the digit, its style, and its input field
        selectedInput.value = selectedDigits.filter(digit => digit !== num).join(',');
        element.classList.remove('selected');
        const inputToRemove = document.getElementById('amount_' + num);
        if (inputToRemove) {
            amountInputsDiv.removeChild(inputToRemove);
        }
    } else {
        // Otherwise, add the digit, its style, and its input field
        selectedDigits.push(num);
        selectedInput.value = selectedDigits.join(',');
        element.classList.add('selected');
        // const amountLabel = document.createElement('label');
        // amountLabel.textContent = 'ထိုးကြေးသတ်မှတ်ပါ ' + num;
        const amountInput = document.createElement('input');
        amountInput.setAttribute('type', 'number');
        amountInput.setAttribute('name', 'amounts[' + num + ']');
        amountInput.setAttribute('id', 'amount_' + num);
        amountInput.setAttribute('placeholder', 'Amount for ' + num);
        amountInput.setAttribute('min', '100');
        amountInput.setAttribute('max', '1000000');
        amountInput.setAttribute('class', 'form-control mt-2');
        // amountInputsDiv.appendChild(amountLabel);
        amountInputsDiv.appendChild(amountInput);
    }

    // Store the current selections to local storage
    storeSelectionsInLocalStorage();
}

function storeSelectionsInLocalStorage() {
    let selections = {};
    document.querySelectorAll('input[name^="amounts["]').forEach(input => {
        let digit = input.name.match(/\[(.*?)\]/)[1];
        let amount = input.value;
        if (amount) { // only add to selections if an amount is entered
            selections[digit] = amount;
        }
    });
    localStorage.setItem('twoDigitSelections', JSON.stringify(selections));
    //window.location.href = "{{ url('/user/two-d-play-9-30-early-morning-confirm') }}";
}


  function permuteDigits() {
    const outputField = document.getElementById('selected_digits');
    const permulatedField = document.getElementById('permulated_digit');

    if (!outputField || !permulatedField) {
      console.error('Required field not found');
      return;
    }

    let selectedDigits = outputField.value.split(",").map(s => s.trim());

    // Permute the digits only if they are two digits long
    const permutedDigits = selectedDigits.map(num => {
      return (num.length === 2) ? num[1] + num[0] : num;
    });

    // Update the outputField with both selected and permuted digits
    outputField.value = `${selectedDigits.join(", ")}`;

    // Update the permulatedField with the permuted digits only
    permulatedField.value = permutedDigits.join(",");

    // Combine selectedDigits and permutedDigits while removing duplicates
    const allUniqueDigits = Array.from(new Set([...selectedDigits, ...permutedDigits]));

    // Recreate the amount inputs for all unique digits
    createAmountInputs(allUniqueDigits);
  }

  function createAmountInputs(digits) {
    const amountInputsDiv = document.getElementById('amountInputs');
    amountInputsDiv.innerHTML = ''; // Clear existing amount inputs

    // Create a new input field for each unique digit
    digits.forEach(digit => {
      const amountInput = document.createElement('input');
      amountInput.type = 'number';
      amountInput.name = `amounts[${digit}]`;
      amountInput.id = `amount_${digit}`;
      amountInput.placeholder = `Amount for ${digit}`;
      amountInput.value = '100'; // Set a default value or retrieve the existing value
      amountInput.classList.add('form-control', 'mt-2');
      amountInput.onchange = updateTotalAmount;
      amountInputsDiv.appendChild(amountInput);
    });

    updateTotalAmount(); // Update the total amount to reflect changes
  }


  function checkBetAmount(inputElement, num) {
    // Replace the problematic line with the following code
    const digits = document.querySelectorAll('.digit');
    let digitElement = null;

    for (let i = 0; i < digits.length; i++) {
      if (digits[i].textContent.includes(num)) {
        digitElement = digits[i];
        break;
      }
    }

    // Ensure that the digitElement was found before proceeding
    if (!digitElement) {
      console.error('Could not find the digit element for', num);
      return;
    }

    // Continue with the rest of your function as before
    const remainingAmount = Number(digitElement.querySelector('small').innerText.split(' ')[1]);

    // Check if the entered bet amount exceeds the remaining amount
    if (Number(inputElement.value) > remainingAmount) {
      Swal.fire({
        icon: 'error',
        title: 'Bet Limit Exceeded',
        text: `You can only bet up to ${remainingAmount} for the digit ${num}.`
      });
      inputElement.value = ""; // Reset the input value
    }
  }

  function setAmountForAllDigits(amount) {
    const inputs = document.querySelectorAll('input[name^="amounts["]');
    inputs.forEach(input => {
      input.value = amount;
    });
    updateTotalAmount(); // Update the total amount after setting the new amounts
  }

  // Event listener for the amount input field
  document.getElementById('all_amount').addEventListener('input', function() {
    const amount = this.value; // Get the current value of the input field
    setAmountForAllDigits(amount); // Set this amount for all digit inputs
  });
  // New function to calculate and display the total amount
  function updateTotalAmount() {
    let total = 0;
    const inputs = document.querySelectorAll('input[name^="amounts["]');
    inputs.forEach(input => {
      total += Number(input.value);
    });

    // Get the user's current balance from the data attribute
    const userBalanceSpan = document.getElementById('userBalance');
    let userBalance = Number(userBalanceSpan.getAttribute('data-balance'));

    // Check if user balance is less than total amount
    if (userBalance < total) {
      //alert('Your balance is not enough to play two digit.');
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Your balance is not enough to play two digit. - သင်၏လက်ကျန်ငွေ မလုံလောက်ပါ - ကျေးဇူးပြု၍ ငွေဖြည့်ပါ။',
        footer: `<a href=
         "{{ url('user/wallet-deposite') }}" style="background-color: #007BFF; color: #FFFFFF; padding: 5px 10px; border-radius: 5px; text-decoration: none;">Fill Balance - ငွေဖြည့်သွင်းရန် နိုပ်ပါ </a>`
      });
      return; // Exit the function to prevent further changes
    }
    // Decrease the user balance by the total
    userBalance -= total;

    // Update the displayed balance and the data attribute
    userBalanceSpan.textContent = userBalance;
    userBalanceSpan.setAttribute('data-balance', userBalance);

    document.getElementById('totalAmount').value = total;
  }

</script>
<script>
  function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

  document.querySelectorAll('.digit.disabled').forEach(el => {
    el.style.backgroundColor = getRandomColor();
  });
</script>
@endsection

