@extends('user_layouts.master')

@section('content')
@include('user_layouts.navbar')
<div class="mt-5 pt-5">
    <!-- content section -->
    <div class="d-flex justify-content-between">
        <div>
            <div>
                <i class="fas fa-wallet me-2"></i><span>Balance</span>
                <span class="d-block" id="userBalance" data-balance="{{ Auth::user()->balance }}">{{ number_format(Auth::user()->balance) }} MMK</span>
            </div>
            <div class="mt-4">
                @php
                    use Carbon\Carbon;
                    $currentTime = Carbon::now();
                @endphp
                <small class="d-block mb-2">2D
                    @if ($currentTime->lte(Carbon::parse('09:30')))
                        {{ "(09:30AM)" }}
                    @elseif ($currentTime->lte(Carbon::parse('12:00')))
                        {{ "(12:00PM)" }}
                    @elseif ($currentTime->lte(Carbon::parse('14:00')))
                        {{ "(02:00PM)" }}
                    @elseif ($currentTime->lte(Carbon::parse('16:30')))
                        {{ "(04:30PM)" }}
                    @else
                        <span class="text-danger">{{ "(ပွဲချိန်များ ပိတ်ပါပြီ။)" }}</span>
                    @endif
                </small>


                <a href="{{ route('user.twod-play-index-9am') }}" class="btn btn-sm btn-purple text-white">ထိုးမည်</a> <br><br>

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
    <div class="container mt-4" id="dreamContainer" style="max-height: 500px;overflow: auto;">
        <div class="row" id="dreamRow"></div>
    </div>
    <!-- content section -->
</div>

{{-- @include('user_layouts.footer') --}}
@endsection

@section('script')
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
    const dreams = [
    { title: "Siren bird", imgSrc: "user_app/assets/images/2ddreambook/2ddream7.png", btn1: "00", btn2: "32" },
    { title: "Graduate", imgSrc: "user_app/assets/images/2ddreambook/2ddream8.png", btn1: "01", btn2: "38" },
    { title: "Electric lamp", imgSrc: "user_app/assets/images/2ddreambook/2ddream9.png", btn1: "02", btn2: "92" },
    { title: "Sun", imgSrc: "user_app/assets/images/2ddreambook/2ddream1.png", btn1: "03", btn2: "26" },
    { title: "Moon", imgSrc: "user_app/assets/images/2ddreambook/2ddream2.jpg", btn1: "04", btn2: "39" },
    { title: "Lion", imgSrc: "user_app/assets/images/2ddreambook/2ddream3.png", btn1: "05", btn2: "93" },
    { title: "Raining", imgSrc: "user_app/assets/images/2ddreambook/2ddream4.png", btn1: "06", btn2: "84" },
    { title: "Wind", imgSrc: "user_app/assets/images/2ddreambook/2ddream5.png", btn1: "07", btn2: "68" },
    { title: "Cloud", imgSrc: "user_app/assets/images/2ddreambook/2ddream6.png", btn1: "08", btn2: "67" },
    { title: "Desk", imgSrc: "user_app/assets/images/2ddreambook/2ddream10.png", btn1: "09", btn2: "27" },
    { title: "Dragon", imgSrc: "user_app/assets/images/2ddreambook/2ddream11.png", btn1: "10", btn2: "54" },
    { title: "The sky", imgSrc: "user_app/assets/images/2ddreambook/2ddream12.png", btn1: "11", btn2: "04" },
    { title: "home", imgSrc: "user_app/assets/images/2ddreambook/2ddream13.png", btn1: "12", btn2: "96" },
    { title: "Holy Spirit", imgSrc: "user_app/assets/images/2ddreambook/2ddream14.png", btn1: "13", btn2: "09" },
    { title: "Pagoda", imgSrc: "user_app/assets/images/2ddreambook/2ddream15.png", btn1: "15", btn2: "62" },
    { title: "Heron", imgSrc: "user_app/assets/images/2ddreambook/2ddream16.png", btn1: "16", btn2: "89" },
    { title: "Roll the mat", imgSrc: "user_app/assets/images/2ddreambook/2ddream17.png", btn1: "18", btn2: "86" },
    { title: "Mosquito trap", imgSrc: "user_app/assets/images/2ddreambook/2ddream18.png", btn1: "19", btn2: "66" },
    { title: "fight", imgSrc: "user_app/assets/images/2ddreambook/2ddream19.png", btn1: "20", btn2: "79" },
    { title: "Calendar", imgSrc: "user_app/assets/images/2ddreambook/2ddream20.png", btn1: "21", btn2: "33" },
    { title: "Dove", imgSrc: "user_app/assets/images/2ddreambook/2ddream21.png", btn1: "22", btn2: "50" },
    { title: "Pig", imgSrc: "user_app/assets/images/2ddreambook/2ddream22.png", btn1: "23", btn2: "40" },
    { title: "Rose", imgSrc: "user_app/assets/images/2ddreambook/2ddream23.png", btn1: "24", btn2: "85" },
    { title: "Mustard leaves", imgSrc: "user_app/assets/images/2ddreambook/2ddream24.png", btn1: "25", btn2: "49" },
    { title: "Kite bird", imgSrc: "user_app/assets/images/2ddreambook/2ddream25.png", btn1: "26", btn2: "77" },
    { title: "Patient", imgSrc: "user_app/assets/images/2ddreambook/2ddream26.png", btn1: "27", btn2: "81" },
    { title: "Little bird", imgSrc: "user_app/assets/images/2ddreambook/2ddream27.png", btn1: "28", btn2: "00" },
    { title: "Cobra", imgSrc: "user_app/assets/images/2ddreambook/2ddream28.png", btn1: "29", btn2: "75" },
    { title: "Tiger arrow", imgSrc: "user_app/assets/images/2ddreambook/2ddream29.png", btn1: "30", btn2: "88" },
    { title: "The problem", imgSrc: "user_app/assets/images/2ddreambook/2ddream30.png", btn1: "31", btn2: "44" },
    { title: "Church", imgSrc: "user_app/assets/images/2ddreambook/2ddream31.png", btn1: "32", btn2: "01" },
    { title: "Virgin", imgSrc: "user_app/assets/images/2ddreambook/2ddream32.png", btn1: "33", btn2: "58" },
    { title: "Fresh fruit", imgSrc: "user_app/assets/images/2ddreambook/2ddream33.png", btn1: "34", btn2: "69" },
    { title: "Paytaung", imgSrc: "user_app/assets/images/2ddreambook/2ddream34.png", btn1: "35", btn2: "94" },
    { title: "Ear", imgSrc: "user_app/assets/images/2ddreambook/2ddream35.png", btn1: "36", btn2: "72" },
    { title: "The barber", imgSrc: "user_app/assets/images/2ddreambook/2ddream36.png", btn1: "37", btn2: "82" },
    { title: "Rake", imgSrc: "user_app/assets/images/2ddreambook/2ddream37.png", btn1: "38", btn2: "70" },
    { title: "Chicken", imgSrc: "user_app/assets/images/2ddreambook/2ddream38.png", btn1: "39", btn2: "11" },
    { title: "Shirt", imgSrc: "user_app/assets/images/2ddreambook/2ddream39.png", btn1: "40", btn2: "22" },
    { title: "Iron rod", imgSrc: "user_app/assets/images/2ddreambook/2ddream40.png", btn1: "42", btn2: "96" },
    { title: "Mirror", imgSrc: "user_app/assets/images/2ddreambook/2ddream41.png", btn1: "43", btn2: "52" },
    { title: "Coconut", imgSrc: "user_app/assets/images/2ddreambook/2ddream42.png", btn1: "44", btn2: "65" },
    { title: "A headache", imgSrc: "user_app/assets/images/2ddreambook/2ddream43.png", btn1: "46", btn2: "65" },
    { title: "God worshiped", imgSrc: "user_app/assets/images/2ddreambook/2ddream44.png", btn1: "47", btn2: "65" },
    { title: "Long bean", imgSrc: "user_app/assets/images/2ddreambook/2ddream45.png", btn1: "48", btn2: "65" },
    { title: "Follower", imgSrc: "user_app/assets/images/2ddreambook/2ddream46.png", btn1: "49", btn2: "45" },
    { title: "Drawer", imgSrc: "user_app/assets/images/2ddreambook/2ddream47.png", btn1: "50", btn2: "59" },
    { title: "Hummingbird", imgSrc: "user_app/assets/images/2ddreambook/2ddream48.png", btn1: "51", btn2: "48" },
    { title: "Paper money", imgSrc: "user_app/assets/images/2ddreambook/2ddream49.png", btn1: "53", btn2: "17" },
    { title: "Shoes", imgSrc: "user_app/assets/images/2ddreambook/2ddream50.png", btn1: "54", btn2: "02" },
    { title: "Lighter", imgSrc: "user_app/assets/images/2ddreambook/2ddream51.png", btn1: "55", btn2: "08" },
    { title: "Chain", imgSrc: "user_app/assets/images/2ddreambook/2ddream52.png", btn1: "57", btn2: "13" },
    { title: "White dog", imgSrc: "user_app/assets/images/2ddreambook/2ddream53.png", btn1: "58", btn2: "07" },
    { title: "Brick", imgSrc: "user_app/assets/images/2ddreambook/2ddream54.png", btn1: "59", btn2: "87" },
    { title: "fish", imgSrc: "user_app/assets/images/2ddreambook/2ddream55.png", btn1: "60", btn2: "78" },
    { title: "Flute", imgSrc: "user_app/assets/images/2ddreambook/2ddream56.png", btn1: "61", btn2: "57" },
    { title: "Maung", imgSrc: "user_app/assets/images/2ddreambook/2ddream57.png", btn1: "62", btn2: "16" },
    { title: "လင်းကွင်း", imgSrc: "user_app/assets/images/2ddreambook/2ddream58.png", btn1: "63", btn2: "97" },
    { title: "ခေါင်းလောင်း", imgSrc: "user_app/assets/images/2ddreambook/2ddream59.png", btn1: "64", btn2: "91" },
    { title: "သစ္စာပန်း", imgSrc: "user_app/assets/images/2ddreambook/2ddream60.png", btn1: "65", btn2: "18" },
    { title: "ခေါင်းအုံး", imgSrc: "user_app/assets/images/2ddreambook/2ddream61.png", btn1: "66", btn2: "71" },
    { title: "မိန်းမ", imgSrc: "user_app/assets/images/2ddreambook/2ddream62.png", btn1: "67", btn2: "41" },
    { title: "ဘတ်မင်တန်", imgSrc: "user_app/assets/images/2ddreambook/2ddream63.png", btn1: "68", btn2: "90" },
    { title: "နို့", imgSrc: "user_app/assets/images/2ddreambook/2ddream64.png", btn1: "69", btn2: "12" },
    { title: "ဆေးလိပ်ပြောင်", imgSrc: "user_app/assets/images/2ddreambook/2ddream65.png", btn1: "70", btn2: "14" },
    { title: "စာရေးမ", imgSrc: "user_app/assets/images/2ddreambook/2ddream66.png", btn1: "71", btn2: "03" },
    { title: "ဝတ်စုံ", imgSrc: "user_app/assets/images/2ddreambook/2ddream67.png", btn1: "72", btn2: "43" },
    { title: "မှတ်စုစာအုပ်", imgSrc: "user_app/assets/images/2ddreambook/2ddream68.png", btn1: "73", btn2: "24" },
    { title: "လည်ရှည်ဖိနပ်", imgSrc: "user_app/assets/images/2ddreambook/2ddream69.png", btn1: "74", btn2: "28" },
    { title: "သိမ်ကျောင်း", imgSrc: "user_app/assets/images/2ddreambook/2ddream70.png", btn1: "75", btn2: "25" },
    { title: "လိပ်", imgSrc: "user_app/assets/images/2ddreambook/2ddream71.png", btn1: "76", btn2: "29" },
    { title: "ဆင်", imgSrc: "user_app/assets/images/2ddreambook/2ddream72.png", btn1: "77", btn2: "15" },
    { title: "ပန်းရနံ့", imgSrc: "user_app/assets/images/2ddreambook/2ddream73.png", btn1: "78", btn2: "20" },
    { title: "ကင်းမြှီးကောက်", imgSrc: "user_app/assets/images/2ddreambook/2ddream74.png", btn1: "79", btn2: "46" },
    { title: "ဆီမီးခွက်", imgSrc: "user_app/assets/images/2ddreambook/2ddream75.png", btn1: "80", btn2: "23" },
    { title: "အလေးမသူ", imgSrc: "user_app/assets/images/2ddreambook/2ddream76.png", btn1: "81", btn2: "05" },
    { title: "ခရားအိုး", imgSrc: "user_app/assets/images/2ddreambook/2ddream77.png", btn1: "82", btn2: "06" },
    { title: "ကနစိုသီး", imgSrc: "user_app/assets/images/2ddreambook/2ddream78.png", btn1: "83", btn2: "61" },
    { title: "ခြံသမား", imgSrc: "user_app/assets/images/2ddreambook/2ddream79.png", btn1: "84", btn2: "30" },
    { title: "စဥ့်အိုး", imgSrc: "user_app/assets/images/2ddreambook/2ddream80.png", btn1: "85", btn2: "76" },
    { title: "ဆရာဝန်မ", imgSrc: "user_app/assets/images/2ddreambook/2ddream81.png", btn1: "86", btn2: "53" },
    { title: "မိခင်နို့တိုက်", imgSrc: "user_app/assets/images/2ddreambook/2ddream82.png", btn1: "87", btn2: "35" },
    { title: "စစ်သား", imgSrc: "user_app/assets/images/2ddreambook/2ddream83.png", btn1: "88", btn2: "63" },
    { title: "စောင့်မျှော်နေသူ", imgSrc: "user_app/assets/images/2ddreambook/2ddream84.png", btn1: "89", btn2: "37" },
    { title: "စားပွဲထိုး", imgSrc: "user_app/assets/images/2ddreambook/2ddream85.png", btn1: "90", btn2: "47" },
    { title: "အင်္ကျီ", imgSrc: "user_app/assets/images/2ddreambook/2ddream86.png", btn1: "91", btn2: "42" },
    { title: "ခရီးသွား", imgSrc: "user_app/assets/images/2ddreambook/2ddream87.png", btn1: "92", btn2: "31" },
    { title: "သစ်သီးခြင်း", imgSrc: "user_app/assets/images/2ddreambook/2ddream88.png", btn1: "93", btn2: "74" },
    { title: "ဒရမ်", imgSrc: "user_app/assets/images/2ddreambook/2ddream89.png", btn1: "94", btn2: "55" },
    { title: "ပုစွန်ခြောက်", imgSrc: "user_app/assets/images/2ddreambook/2ddream90.png", btn1: "95", btn2: "83" },
    { title: "ဖရုံသီး", imgSrc: "user_app/assets/images/2ddreambook/2ddream91.png", btn1: "96", btn2: "34" },
    { title: "အရှုံးပေး", imgSrc: "user_app/assets/images/2ddreambook/2ddream92.png", btn1: "97", btn2: "21" },
    { title: "ဆေးပုလင်း", imgSrc: "user_app/assets/images/2ddreambook/2ddream93.png", btn1: "98", btn2: "64" },
    { title: "လူသေကောင်", imgSrc: "user_app/assets/images/2ddreambook/2ddream94.png", btn1: "99", btn2: "66" },

    ];

    const dreamContainer = document.getElementById("dreamContainer");
    const dreamRow = document.getElementById("dreamRow");

    dreams.forEach((dream) => {
      const dreamHTML = `
        <div class="col-md-3 col-4 mt-3">
          <p class="dream-header">${dream.title}</p>
          <div class="dream-img">
            <img src="https://shwesin123.com/${dream.imgSrc}" alt="" style="width:inherit;height:inherit">
          </div>
          <div class="d-flex justify-content-between">
            <button class="dream-btn w-50" >${dream.btn1}</button>
            <button class="dream-btn w-50">${dream.btn2}</button>
          </div>
        </div>
      `;


      dreamRow.innerHTML += dreamHTML;
    });


    dreamContainer.appendChild(dreamRow);

    var buttons = document.querySelectorAll('.dream-btn');

    buttons.forEach(function(button) {
      button.addEventListener('click', function() {
          this.classList.toggle('selected');

        });
      });
  </script>
    <script>
    function goBack() {
      window.history.back();
    }

    function refreshPage() {
      location.reload();
    }
  </script>
@endsection
