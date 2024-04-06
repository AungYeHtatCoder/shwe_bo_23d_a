@extends('user_layouts.master')

@section('style')

@endsection

@section('content')
@include('user_layouts.navbar')
<!-- content -->
<div class="container-fluid position-relative py-5 my-5">
 <!-- wallet and bet time section  -->
 <div class="d-flex justify-content-between">
  <div>
   <div>
    <i class="fas fa-wallet me-2"></i><span>Balance</span>
    <span class="d-block" id="userBalance">500000 MMK</span>
   </div>
   <a href="{{ url('/user/three-d-choice-play-index') }}" class="btn btn-sm btn-purple text-white mt-3">ထိုးမည်</a> <br><br>
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
<!-- content -->

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
  const dreams = [{
      title: 'သံဗူး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream1.png',
      btn1: '000',
      btn2: '498',
    },
    {
      title: 'နဂါး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream2.png',
      btn1: '001',
      btn2: '545',
    },
    {
      title: 'မှန်ဘီလူး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream3.png',
      btn1: '002',
      btn2: '503',
    },
    {
      title: 'ဓားဆောင်သူ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream4.png',
      btn1: '003',
      btn2: '502',
    },
    {
      title: 'ဒိုင်နိုဆော',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream5.png',
      btn1: '004',
      btn2: '515',
    },
    {
      title: 'ခြင်္သေ့',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream6.png',
      btn1: '005',
      btn2: '539',
    },
    {
      title: 'သိမ်းငှက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream7.png',
      btn1: '006',
      btn2: '541',
    },
    {
      title: 'ကျားခေါင်း',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream8.png',
      btn1: '007',
      btn2: '508',
    },
    {
      title: 'လက်သုတ်စက္ကူ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream9.png',
      btn1: '008',
      btn2: '507',
    },
    {
      title: 'လူရည်ချွန်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream10.png',
      btn1: '009',
      btn2: '537',
    },
    {
      title: 'ဥသြဌက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream11.png',
      btn1: '010',
      btn2: '532',
    },
    {
      title: 'နတ်ပြည်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream12.png',
      btn1: '011',
      btn2: '527',
    },
    {
      title: 'စာရင်းကိုင်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream13.png',
      btn1: '012',
      btn2: '519',
    },
    {
      title: 'ဆတ်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream14.png',
      btn1: '013',
      btn2: '529',
    },
    {
      title: 'ငုံး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream15.png',
      btn1: '014',
      btn2: '546',
    },
    {
      title: 'မြင်း',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream16.png',
      btn1: '015',
      btn2: '504',
    },
    {
      title: 'ပျံလွှားငှက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream17.png',
      btn1: '016',
      btn2: '544',
    },
    {
      title: 'နွား',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream18.png',
      btn1: '017',
      btn2: '538',
    },
    {
      title: 'လားဟူလူမျိုး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream19.png',
      btn1: '018',
      btn2: '528',
    },
    {
      title: 'တင်းနစ်ကစားသူ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream20.png',
      btn1: '019',
      btn2: '512',
    },
    {
      title: 'ကျီးကန်း',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream21.png',
      btn1: '020',
      btn2: '522',
    },
    {
      title: 'ရွာဆော်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream22.png',
      btn1: '021',
      btn2: '543',
    },
    {
      title: 'ချိုးငှက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream23.png',
      btn1: '022',
      btn2: '520',
    },
    {
      title: 'ဝက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream24.png',
      btn1: '023',
      btn2: '534',
    },
    {
      title: 'အောက်ချင်းငှက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream25.png',
      btn1: '024',
      btn2: '516',
    },
    {
      title: 'တားမြစ်သူ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream26.png',
      btn1: '025',
      btn2: '535',
    },
    {
      title: 'ဘီလုံးငှက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream27.png',
      btn1: '026',
      btn2: '540',
    },
    {
      title: 'ကြိုဆိုသူ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream28.png',
      btn1: '027',
      btn2: '511',
    },
    {
      title: 'ယင်းနက်လူမျို',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream29.png',
      btn1: '028',
      btn2: '518',
    },
    {
      title: 'ဝံပုလွေ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream30.png',
      btn1: '029',
      btn2: '513',
    },
    {
      title: 'မုဆိုး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream31.png',
      btn1: '030',
      btn2: '549',
    },
    {
      title: 'လေးသမား',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream32.png',
      btn1: '031',
      btn2: '544',
    },
    {
      title: 'နာဂလူမျိုး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream33.png',
      btn1: '032',
      btn2: '510',
    },
    {
      title: 'ရခိုင်လူမျိုး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream34.png',
      btn1: '033',
      btn2: '536',
    },
    {
      title: 'လင်မယား',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream35.png',
      btn1: '034',
      btn2: '523',
    },
    {
      title: 'အိမ်ရှေ့မင်း',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream36.png',
      btn1: '035',
      btn2: '525',
    },
    {
      title: 'အလှမယ်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream37.png',
      btn1: '036',
      btn2: '533',
    },
    {
      title: 'ဖုံစုပ်စက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream38.png',
      btn1: '037',
      btn2: '509',
    },
    {
      title: 'ပင့်ကူ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream39.png',
      btn1: '038',
      btn2: '517',
    },
    {
      title: 'ခြင်ဆေးဗူး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream40.png',
      btn1: '039',
      btn2: '505',
    },
    {
      title: 'လူငယ်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream41.png',
      btn1: '040',
      btn2: '526',
    },
    {
      title: 'အဲန်လူမျိုး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream42.png',
      btn1: '041',
      btn2: '506',
    },
    {
      title: 'မွတ်ဆလင်မယ်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream43.png',
      btn1: '042',
      btn2: '547',
    },
    {
      title: 'တုတ်သိုင်းသမား',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream44.png',
      btn1: '043',
      btn2: '521',
    },
    {
      title: 'ဖျံ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream45.png',
      btn1: '044',
      btn2: '531',
    },
    {
      title: 'ပင်လယ်ပုဇွန်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream46.png',
      btn1: '045',
      btn2: '501',
    },
    {
      title: 'မီးပုံးကိုင်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream47.png',
      btn1: '046',
      btn2: '514',
    },
    {
      title: 'အပုပ်နံ့',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream48.png',
      btn1: '047',
      btn2: '542',
    },
    {
      title: 'ပျားပျံ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream49.png',
      btn1: '048',
      btn2: '550',
    },
    {
      title: 'ပုစဉ်းရင်ကွဲ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream50.png',
      btn1: '049',
      btn2: '530',
    },
    {
      title: 'ဟင်္သာ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream51.png',
      btn1: '050',
      btn2: '548',
    },
    {
      title: 'ပုတီးစိတ်သူ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream52.png',
      btn1: '051',
      btn2: '595',
    },
    {
      title: 'ဥဒေါင်း',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream53.png',
      btn1: '052',
      btn2: '553',
    },
    {
      title: 'သိုးနယား',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream54.png',
      btn1: '053',
      btn2: '552',
    },
    {
      title: 'ထိုင်းလူမျိုး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream55.png',
      btn1: '054',
      btn2: '565',
    },
    {
      title: 'ကိန္နရီ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream56.png',
      btn1: '055',
      btn2: '589',
    },
    {
      title: 'ဂဠုန်မင်း',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream57.png',
      btn1: '056',
      btn2: '591',
    },
    {
      title: 'အဝတ်လျှော်စက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream58.png',
      btn1: '057',
      btn2: '558',
    },
    {
      title: 'လူအို',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream59.png',
      btn1: '058',
      btn2: '557',
    },
    {
      title: 'ကျားသစ်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream60.png',
      btn1: '059',
      btn2: '587',
    },
    {
      title: 'အခါမလေး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream61.png',
      btn1: '060',
      btn2: '582',
    },
    {
      title: 'ဆင်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream62.png',
      btn1: '061',
      btn2: '577',
    },
    {
      title: 'ရေဘဲ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream63.png',
      btn1: '062',
      btn2: '569',
    },
    {
      title: 'ပြဒါးတိုင်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream64.png',
      btn1: '063',
      btn2: '579',
    },
    {
      title: 'ရသေ့',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream65.png',
      btn1: '064',
      btn2: '596',
    },
    {
      title: 'သစ်ရွက်ကိုင်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream66.png',
      btn1: '065',
      btn2: '554',
    },
    {
      title: 'ထီးကိုင်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream67.png',
      btn1: '066',
      btn2: '574',
    },
    {
      title: 'ထောက်ကွန်ပါ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream68.png',
      btn1: '067',
      btn2: '588',
    },
    {
      title: 'ဘဲ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream69.png',
      btn1: '068',
      btn2: '578',
    },
    {
      title: 'သမင်နက်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream70.png',
      btn1: '069',
      btn2: '562',
    },
    {
      title: 'သိမ်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream71.png',
      btn1: '070',
      btn2: '572',
    },
    {
      title: 'အလေးပြု',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream72.png',
      btn1: '071',
      btn2: '593',
    },
    {
      title: 'အောက်လင်းမီး',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream73.png',
      btn1: '072',
      btn2: '570',
    },
    {
      title: 'ဒေါင်းတောင်ကိုင်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream74.png',
      btn1: '073',
      btn2: '584',
    },
    {
      title: 'မြင်းကျား',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream75.png',
      btn1: '074',
      btn2: '566',
    },
    {
      title: 'ခွေးဖြူ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream76.png',
      btn1: '075',
      btn2: '585',
    },
    {
      title: 'ဓါးပြဗိုလ်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream77.png',
      btn1: '076',
      btn2: '590',
    },
    {
      title: 'ကြောင်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream78.png',
      btn1: '077',
      btn2: '561',
    },
    {
      title: 'လင်းဆွဲ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream79.png',
      btn1: '078',
      btn2: '568',
    },
    {
      title: 'ပန်းကိုင်',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream80.png',
      btn1: '079',
      btn2: '563',
    },
    {
      title: 'ကြက်ဖ',
      imgSrc: 'user_app/assets/img/3ddreambook/3ddream81.png',
      btn1: '080',
      btn2: '599',
    },
  ];

  const dreamContainer = document.getElementById('dreamContainer');

  const dreamRow = document.getElementById('dreamRow');

 dreams.forEach((dream) => {
  const dreamHTML = `
    <div class="col-sm-3 col-4 mt-3">
      <p class="dream-header">${dream.title}</p>
      <div class="dream-img">
        <img src="{{ asset('${dream.imgSrc}') }}" alt="" style="width:inherit;height:inherit" class="img-fluid">
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
@endsection
