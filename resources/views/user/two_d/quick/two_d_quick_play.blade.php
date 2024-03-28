@extends('user_layouts.master')
@section('style')
<link rel="stylesheet" href="{{ asset('user_app/assets/css/balance.css')}}">
@endsection
@section('content')
@include('user_layouts.navbar')
<div class="">
    <div class="mt-5 pt-5">
        <div class="d-flex justify-content-between">
            <div>
                <div>
                    <i class="fas fa-wallet me-2"></i><span>Balance</span>
                    <span class="d-block" id="userBalance" data-balance="{{ Auth::user()->balance }}">{{ number_format(Auth::user()->balance) }} MMK</span>
                </div>
                <div class="mt-4">
                    <small class="d-block mb-2">2D (12:00PM)</small>
                    <a href="{{ route('user.twod-play-index') }}" class="btn btn-sm btn-purple text-white">ပုံမှန်ရွေး</a>
                </div>
            </div>

            <div>
                <small class="d-block mb-2 text-end">
                    <i class="fas fa-clock text-white me-1"></i>
                    ပိတ်ရန်ကျန်ချိန်
                </small>
                <small class="d-block text-end" id="todayDate"></small>
                <small class="d-block text-end" id="currentTime"></small>
                <small class="d-block text-end" id="sessionInfo"></small>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <div class="mb-3 text-end">
            <label for="" class="form-label"><small><i class="fas fa-coins me-2 text-white"></i>ထိုးကြေး</small></label>
            <div class="input-group">
                <input type="text" name="amount" id="all_amount" class="form-control form-control-sm text-center" placeholder="ပမာဏ">
                <button class="btn btn-sm btn-purple text-white" type="button"  id="permuteButton" onclick="permuteDigits()"><small>ပတ်လည်</small></button>
            </div>
        </div>
    </div>

    <form action="" method="post" class="p-1">
        @csrf
        <div class="mb-3">
            <input type="text" id="outputField" name="selected_digits" class="form-control form-control-sm" placeholder="Selected digits">
        </div>
        <div class="mb-3 mt-3">

            <label class="form-label mb-2" for="permulated_digit" style="font-size: 14px;">ပတ်လည် ဂဏန်းများ</label>
            <input type="text" id="permulated_digit" class="form-control form-control-sm" readonly>
        </div>

        <!-- Amounts Inputs will be appended here -->
        <div id="amountInputs" class="col-md-12 mb-3 d-none"></div>

        <!-- Total Amount Input -->
        <div class="col-md-12 mb-3">
            <label for="totalAmount" style="font-size: 14px;" class="form-label mb-2"><i class="fas fa-coins me-2 text-white"></i>စုစုပေါင်းထိုးကြေး</label>
            <input type="text" id="totalAmount" name="totalAmount" class="form-control form-control-sm" readonly>
        </div>
        <div class="d-flex justify-content-end my-2" >
            <button class="btn btn-sm btn-danger me-2" type="reset"><small>ဖျက်မည်</small></button>
            <a href="{{ route('user.twod-play-confirm-quick') }}" onclick="storeSelectionsInLocalStorage()" class="btn btn-sm btn-purple text-white"><small>ထိုးမည်</small></a>
        </div>

        <!-- User ID Hidden Input -->
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    </form>

    <div class="dream-form">
        <div class="box-container d-none" id="boxContainer">
            <div class="main-row">
                @foreach ($twoDigits as $digit)
                <div class="column">
                    @php
                    $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
                    ->where('two_digit_id', $digit->id)
                    ->sum('sub_amount');
                    @endphp
                @if ($totalBetAmountForTwoDigit < 1000000)
                <div class="text-center digit digit-button" style="background-color: javascript:getRandomColor();" data-digit="{{ $digit->two_digit }}" onclick="selectDigit('{{ $digit->two_digit }}', this)">
                    <p style="font-size: 20px">
                    {{ $digit->two_digit }}
                    </p>
                    <div class="progress">
                        @php
                        $totalAmount = 1000000;
                        $betAmount = $totalBetAmountForTwoDigit; // the amount already bet
                        $remainAmount = $totalAmount - $betAmount; // the amount remaining that can be bet
                        $percentage = ($betAmount / $totalAmount) * 100;
                        @endphp

                        <div class="progress-bar" style="width: {{ $percentage }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <small class="d-none" style="font-size: 10px">{{ $remainingAmounts[$digit->id] }}</small>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-2 text-center digit disabled" style="background-color: {{ 'javascript:getRandomColor();' }}" onclick="showLimitFullAlert()">
                    {{ $digit->two_digit }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    <div>
        <div id="buttonContainer1" class="buttonContainer">
            <div class="">
                <button class="btn btn-sm btn-purple text-white mb-2" data-bs-target="#singledouble_modal" data-bs-toggle="modal">Single & Double</button>
                <button class="btn btn-sm btn-purple text-white mb-2" data-bs-target="#break_modal" data-bs-toggle="modal">ဘရိတ်</button>
                <button class="btn btn-sm btn-purple text-white mb-2" data-bs-target="#round_modal" data-bs-toggle="modal">ပတ်သီး</button>
                <button type="button" id="myanmar_power" class="btn btn-sm btn-purple text-white mb-2">ပါ၀ါတွဲ</button>
                <button type="button" id="thai_power" class="btn btn-sm btn-purple text-white mb-2">နက္ခတ်တွဲ</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- ပတ်သီး -->
<div class="modal fade" id="round_modal">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
          <div class="d-flex justify-content-between">
            <small class="text-purple">ပတ်သီး</small>
            <button type="button" class="btn-sm btn-close d-block" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <!-- ပတ်သီး -->
          <div class="quickmodal mb-5">
              <p class="m-3 fw-bold">ပတ်သီး</p>
              <div class="d-flex justify-content-around">
                  <button class="btn btn-sm btn-purple text-purple" type="button" id="zero">0</button>
                  <button class="btn btn-sm btn-purple text-purple" type="button" id="one">1</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="two">2</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="three" >3</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="four" >4</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="five" >5</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="six">6</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="seven">7</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="eight">8</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="nine">9</button>
              </div>
          </div>
      </div>
  </div>

</div>

{{-- ဘရိတ် --}}
<div class="modal fade" id="break_modal" tabindex="-1" aria-labelledby="breakModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
          <div class="d-flex justify-content-between">
                <small class="d-block">ဘရိတ်</small>
                <button type="button" class="btn-close d-block" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>



          <!-- ဘရိတ် -->
          <div class="quickmodal mb-5">
              <p class="m-3 fw-bold">ဘရိတ်</p>
              <div class="d-flex justify-content-between">
                <button class="btn btn-sm btn-purple text-white" type="button" id="zero_break_digit">0</button>
                <button class="btn btn-sm btn-purple text-white" type="button" id="one_break_digit">1/11</button>
                <button class="btn btn-sm btn-purple text-white" type="button" id="two_break_digit">2/12</button>
                <button class="btn btn-sm btn-purple text-white" type="button" id="three_break_digit">3/13</button>
                <button class="btn btn-sm btn-purple text-white" type="button" id="four_break_digit">4/14</button>

              </div>
              <div class="d-flex justify-content-between mt-2">
                <button class="btn btn-sm btn-purple text-white" type="button" id="five_break_digit" >5/15</button>
                <button class="btn btn-sm btn-purple text-white" type="button" id="six_break_digit">6/16</button>
                <button class="btn btn-sm btn-purple text-white" type="button" id="seven_break_digit">7/17</button>
                <button class="btn btn-sm btn-purple text-white" type="button" id="eight_break_digit">8/18</button>
                <button class="btn btn-sm btn-purple text-white" type="button" id="nine_break_digit">9/19</button>
              </div>
          </div>
      </div>
  </div>
</div>

{{-- single & double --}}
<div class="modal fade" id="singledouble_modal">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <small>Single & Double</small>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

          <!-- ဘရိတ် -->
          <div class="quickmodal mb-5">
              <p class="m-3 fw-bold">Single & Double</p>
              <div class="d-flex justify-content-around">
                  <button class="btn btn-sm btn-purple text-white" type="button" id="brother_digit">ညီအကို</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="full_digit">ဆယ်ပြည့်</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="odd">မမ</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="even">စုံစုံ</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="odd_same">မမ အပူး</button>
                  <button class="btn btn-sm btn-purple text-white" type="button" id="even_same">စုံစုံ အပူး</button>
              </div>
          </div>
      </div>
  </div>
</div>



@include('user_layouts.footer')
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
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
    function selectDigit(num, element) {
        const selectedInput = document.getElementById('selected_digits');
        const amountInputsDiv = document.getElementById('amountInputs');

        let selectedDigits = selectedInput.value ? selectedInput.value.split(",") : [];

        // Get the remaining amount for the selected digit
        const remainingAmount = Number(element.querySelector('small').innerText.split(' ')[1]);

        // Check if the user tries to bet more than the remaining amount
        if (selectedDigits.includes(num)) {
            const betAmountInput = document.getElementById('amount_' + num);

            if (Number(betAmountInput.value) > remainingAmount) {
                Swal.fire({
                    icon: 'error',
                    title: 'Bet Limit Exceeded',
                    text: `You can only bet up to ${remainingAmount} for the digit ${num}.`
                });
                return;
            }
        }

        // Check if the digit is already selected
        if (selectedDigits.includes(num)) {
            // If it is, remove the digit, its style, and its input field
            selectedInput.value = selectedInput.value.replace(num, '').replace(',,', ',').replace(/^,|,$/g, '');
            element.classList.remove('selected');

            const inputToRemove = document.getElementById('amount_' + num);
            amountInputsDiv.removeChild(inputToRemove);
        } else {
            // Otherwise, add the digit, its style, and its input field
            selectedInput.value = selectedInput.value ? selectedInput.value + "," + num : num;
            element.classList.add('selected');

            const amountInput = document.createElement('input');
            amountInput.setAttribute('type', 'number');
            amountInput.setAttribute('name', 'amounts[' + num + ']');
            amountInput.setAttribute('id', 'amount_' + num);
            amountInput.setAttribute('placeholder', 'Amount for ' + num);
            amountInput.setAttribute('min', '100');
            amountInput.setAttribute('max', '1000000');
            amountInput.setAttribute('class', 'form-control mt-2 d-none');
            amountInput.onchange = function() {
                updateTotalAmount();
                checkBetAmount(this, num);
            };
            amountInputsDiv.appendChild(amountInput);
        }
        // Store the current selections to local storage
        storeSelectionsInLocalStorage();
    }


</script>
<script>
    // This function handles the click event for all digit buttons
    function handleDigitButtonClick(startDigit) {
        const digitsStartingWith = Array.from(document.querySelectorAll('.digit-button'))
            .filter(button => button.getAttribute('data-digit').startsWith(startDigit))
            .map(button => button.getAttribute('data-digit'));

        // Assuming 'outputField' is where the selected digits will be displayed
        const outputField = document.getElementById('outputField');
        // Add the new digits to the existing ones, separated by a comma
        outputField.value += outputField.value ? ',' + digitsStartingWith.join(',') : digitsStartingWith.join(',');

        createAmountInputs(digitsStartingWith);
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

    // permulation
    function permuteDigits() {
        const outputField = document.getElementById('outputField');
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
    function handleFullClick() {
    // Define the sequence directly
    const fullDigits = '10,20, 30, 40, 50, 60, 70, 80, 90';

    // Assuming 'outputField' is where the selected digits will be displayed
    const outputField = document.getElementById('outputField');
    outputField.value = fullDigits; // Set the static sequence to the output field

    // Convert the string to an array for further processing if needed
    const brotherDigitsArray = fullDigits.split(',');

    // Call any function that needs to react to the new brother digits here
    createAmountInputs(brotherDigitsArray);
}

// Attach the click event handler to the "DigitBrother" button
document.getElementById('full_digit').addEventListener('click', handleFullClick);

function handleZeroBreakClick() {
    // Define the sequence directly
    const zeroDigits = '00';

    // Assuming 'outputField' is where the selected digits will be displayed
    const outputField = document.getElementById('outputField');
    outputField.value = zeroDigits; // Set the static sequence to the output field

    // Convert the string to an array for further processing if needed
    const zeroDigitsArray = zeroDigits.split(',');

    // Call any function that needs to react to the new brother digits here
    createAmountInputs(zeroDigitsArray);
}

// Attach the click event handler to the "DigitBrother" button
document.getElementById('zero_break_digit').addEventListener('click', handleZeroBreakClick);

// One Break Digit
function handleOneBreakClick() {
    // Define the sequence directly
    const oneDigits = '10, 11, 29, 38, 47, 56';

    // Assuming 'outputField' is where the selected digits will be displayed
    const outputField = document.getElementById('outputField');
    outputField.value = oneDigits; // Set the static sequence to the output field

    // Convert the string to an array for further processing if needed
    const OneBreakDigitsArray = oneDigits.split(',');

    // Call any function that needs to react to the new brother digits here
    createAmountInputs(OneBreakDigitsArray);
}

// Attach the click event handler to the "DigitBrother" button
document.getElementById('one_break_digit').addEventListener('click', handleOneBreakClick);
// Two Break Digit
function handleTwoBreakClick() {
    // Define the sequence directly
    const twoDigits = '20, 11, 39, 48, 57, 66';
    const outputField = document.getElementById('outputField');
    outputField.value = twoDigits; // Set the static sequence to the output field
    const TwoBreakDigitsArray = twoDigits.split(',');
    createAmountInputs(TwoBreakDigitsArray);
}
document.getElementById('two_break_digit').addEventListener('click', handleTwoBreakClick);
// Three Break Digit
function handleThreeBreakClick() {
    // Define the sequence directly
    const threeDigits = '12, 30, 49, 58, 67';
    const outputField = document.getElementById('outputField');
    outputField.value = threeDigits; // Set the static sequence to the output field
    const ThreeBreakDigitsArray = threeDigits.split(',');
    createAmountInputs(ThreeBreakDigitsArray);
}
document.getElementById('three_break_digit').addEventListener('click', handleThreeBreakClick);
// Four Break Digit
function handleFourBreakClick() {
    // Define the sequence directly
    const fourDigits = '13, 22, 40, 59, 68, 77';
    const outputField = document.getElementById('outputField');
    outputField.value = fourDigits; // Set the static sequence to the output field
    const FourBreakDigitsArray = fourDigits.split(',');
    createAmountInputs(FourBreakDigitsArray);
}
document.getElementById('four_break_digit').addEventListener('click', handleFourBreakClick);

// Five Break Digit
function handleFiveBreakClick() {
    // Define the sequence directly
    const fiveDigits = '14, 23, 50, 69, 78';
    const outputField = document.getElementById('outputField');
    outputField.value = fiveDigits; // Set the static sequence to the output field
    const FiveBreakDigitsArray = fiveDigits.split(',');
    createAmountInputs(FiveBreakDigitsArray);
}
document.getElementById('five_break_digit').addEventListener('click', handleFiveBreakClick);
// Six Break Digit
function handleSixBreakClick() {
    // Define the sequence directly
    const sixDigits = '15, 24, 33, 60, 79, 88';
    const outputField = document.getElementById('outputField');
    outputField.value = sixDigits; // Set the static sequence to the output field
    const SixBreakDigitsArray = sixDigits.split(',');
    createAmountInputs(SixBreakDigitsArray);
}
document.getElementById('six_break_digit').addEventListener('click', handleSixBreakClick);
// Seven Break Digit
function handleSevenBreakClick() {
    // Define the sequence directly
    const sevenDigits = '16, 25, 34, 43, 70, 89';
    const outputField = document.getElementById('outputField');
    outputField.value = sevenDigits; // Set the static sequence to the output field
    const SevenBreakDigitsArray = sevenDigits.split(',');
    createAmountInputs(SevenBreakDigitsArray);
}
document.getElementById('seven_break_digit').addEventListener('click', handleSevenBreakClick);
// Eight Break Digit
function handleEightBreakClick() {
    // Define the sequence directly
    const eightDigits = '17, 26, 35, 44, 80, 99';
    const outputField = document.getElementById('outputField');
    outputField.value = eightDigits; // Set the static sequence to the output field
    const EightBreakDigitsArray = eightDigits.split(',');
    createAmountInputs(EightBreakDigitsArray);
}
document.getElementById('eight_break_digit').addEventListener('click', handleEightBreakClick);
// Nine Break Digit
function handleNineBreakClick() {
    // Define the sequence directly
    const nineDigits = '18, 27, 36, 45, 90';
    const outputField = document.getElementById('outputField');
    outputField.value = nineDigits; // Set the static sequence to the output field
    const NineBreakDigitsArray = nineDigits.split(',');
    createAmountInputs(NineBreakDigitsArray);
}
document.getElementById('nine_break_digit').addEventListener('click', handleNineBreakClick);
// Myanmar Power
function handleMyanmarPowerClick() {
    // Define the sequence directly
    const myanmarPowerDigits = '05, 16, 27, 38, 49';
    const outputField = document.getElementById('outputField');
    outputField.value = myanmarPowerDigits; // Set the static sequence to the output field
    const MyanmarPowerDigitsArray = myanmarPowerDigits.split(',');
    createAmountInputs(MyanmarPowerDigitsArray);
}
document.getElementById('myanmar_power').addEventListener('click', handleMyanmarPowerClick);
// Thai Power
function handleThaiPowerClick() {
    // Define the sequence directly
    const thaiPowerDigits = '07, 18, 24, 35, 69';
    const outputField = document.getElementById('outputField');
    outputField.value = thaiPowerDigits; // Set the static sequence to the output field
    const ThaiPowerDigitsArray = thaiPowerDigits.split(',');
    createAmountInputs(ThaiPowerDigitsArray);
}
document.getElementById('thai_power').addEventListener('click', handleThaiPowerClick);
    // Brother Digit
function handleDigitBrotherClick() {
    // Define the sequence directly
    const brotherDigits = '01,12,23,34,45,56,67,78,89,09';

    // Assuming 'outputField' is where the selected digits will be displayed
    const outputField = document.getElementById('outputField');
    outputField.value = brotherDigits; // Set the static sequence to the output field

    // Convert the string to an array for further processing if needed
    const brotherDigitsArray = brotherDigits.split(',');

    // Call any function that needs to react to the new brother digits here
    createAmountInputs(brotherDigitsArray);
}

// Attach the click event handler to the "DigitBrother" button
document.getElementById('brother_digit').addEventListener('click', handleDigitBrotherClick);
// Brother Digit end
// Odd start
function handleOddButtonClick() {
    // Get all elements with the class 'digit-button' and filter out the odd digits
    const oddDigits = Array.from(document.querySelectorAll('.digit-button'))
        .filter(button => {
            const digits = button.getAttribute('data-digit').split('');
            return digits.every(digit => parseInt(digit) % 2 !== 0);
        })
        .map(button => button.getAttribute('data-digit'));

    // Assuming 'outputField' is where the selected digits will be displayed
    const outputField = document.getElementById('outputField');
    outputField.value = oddDigits.join(','); // Set the odd digits to the output field, separated by commas

    // Call any function that needs to react to the new odd digits here
    createAmountInputs(oddDigits);
}

// Attach the click event handler to the "Odd" button
document.getElementById('odd').addEventListener('click', handleOddButtonClick);
// Odd end

// Even start
function handleEvenButtonClick() {
    // Get all elements with the class 'digit-button' and filter out the odd digits
    const evenDigits = Array.from(document.querySelectorAll('.digit-button'))
    .map(button => button.getAttribute('data-digit').padStart(2, '0')) // Ensure two digits
    .filter(digit => digit[0] % 2 === 0 && digit[1] % 2 === 0) // Filter numbers where both digits are even
    .sort((a, b) => a.localeCompare(b, undefined, {numeric: true}));
    const outputField = document.getElementById('outputField');
    outputField.value = evenDigits.join(','); // Set
    createAmountInputs(evenDigits);
}

// Attach the click event handler to the "Odd" button
document.getElementById('even').addEventListener('click', handleEvenButtonClick);
// Even end
// Odd same start
function handleOddSameButtonClick() {
    const sameOddDigits = Array.from(document.querySelectorAll('.digit-button'))
        .filter(button => {
            const digit = button.getAttribute('data-digit');
            return digit[0] === digit[1] && parseInt(digit) % 2 !== 0;
        })
        .map(button => button.getAttribute('data-digit'));
    const outputField = document.getElementById('outputField');
    outputField.value = sameOddDigits.join(','); // Set
    createAmountInputs(sameOddDigits);
}

// Attach the click event handler to the "Odd" button
document.getElementById('odd_same').addEventListener('click', handleOddSameButtonClick);
// Odd Same end

// Even same start
function handleEvenSameButtonClick() {
    const sameEvenDigits = Array.from(document.querySelectorAll('.digit-button'))
        .filter(button => {
            const digit = button.getAttribute('data-digit');
            return digit[0] === digit[1] && parseInt(digit) % 2 === 0;
        })
        .map(button => button.getAttribute('data-digit'));
    const outputField = document.getElementById('outputField');
    outputField.value = sameEvenDigits.join(','); // Set
    createAmountInputs(sameEvenDigits);
}

// Attach the click event handler to the "Odd" button
document.getElementById('even_same').addEventListener('click', handleEvenSameButtonClick);



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
            amountInput.classList.add('form-control', 'mt-2', 'd-none');
            amountInput.onchange = updateTotalAmount;
            amountInputsDiv.appendChild(amountInput);
        });

        updateTotalAmount(); // Update the total amount to reflect changes
    }


    // Attach the click event handler to each digit button
    ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'].forEach((id, index) => {
        document.getElementById(id).addEventListener('click', function() {
            handleDigitButtonClick(index.toString());
        });
    });

    function updateOutputField(digits) {
        const outputDiv = document.getElementById('outputField_div');
        outputDiv.innerHTML = '<ul>' + digits.map(num => `<li>${num}</li>`).join('') + '</ul>';
    }
    // permulation end
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

    function updateTotalAmount() {
        let total = 0;
        const inputs = document.querySelectorAll('input[name^="amounts["]'); // Get all amount inputs
        inputs.forEach(input => {
            const value = Number(input.value);
            if (value < 1 || value > 1000000) {
                // If the input value is less than 100 or greater than 5000, show an error and reset the input
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid amount',
                    text: 'The amount for each two-digit number must be between 100 and 5000 MMK.'
                });
                input.value = ''; // Reset the invalid input
            } else {
                total += value; // Add valid input values to the total
            }
        });

        // Check against the user's balance
        const userBalanceSpan = document.getElementById('userBalance');
        let userBalance = Number(userBalanceSpan.getAttribute('data-balance'));

        if (userBalance < total) {
            // If the balance is insufficient, show an error
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Your balance is not enough to play two digit. - သင်၏လက်ကျန်ငွေ မလုံလောက်ပါ - ကျေးဇူးပြု၍ ငွေဖြည့်ပါ။',
                footer: `<a href="{{ url('user/wallet-deposite') }}" style="background-color: #007BFF; color: #FFFFFF; padding: 5px 10px; border-radius: 5px; text-decoration: none;">Fill Balance - ငွေဖြည့်သွင်းရန် နိုပ်ပါ </a>`
            });
        } else {
            // If the balance is sufficient, update the display
            userBalanceSpan.textContent = `လက်ကျန်ငွေ - ${(userBalance - total).toFixed(2)} MMK`; // Format for display
            userBalanceSpan.setAttribute('data-balance', userBalance - total);

            // Update the total amount display
            document.getElementById('totalAmount').value = total.toFixed(2);
        }
    }
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
