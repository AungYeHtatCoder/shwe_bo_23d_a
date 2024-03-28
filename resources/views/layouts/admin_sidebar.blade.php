<div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link text-white" href="{{ route('admin.profile') }}">
        
        @if (Auth::user()->photo == null)
        <i class="fas fa-user-circle fa-2x"></i>
        @else
        <img src="{{ Auth::user()->photo }}" class="rounded-circle" width="100px">
        @endif
        
        <span class="nav-link-text ms-2 ps-1">{{ Auth::user()->name }}</span>
      </a>
    </li>
    <hr class="horizontal light mt-0">
    <li class="nav-item ">
      <a class="nav-link text-white " href="{{ route('home') }}">
        <span class="sidenav-mini-icon"> <i class="fas fa-dashboard"></i> </span>
        <span class="sidenav-normal  ms-2  ps-1"> Dashboard </span>
      </a>
    </li>

    {{-- user management --}}
    @can('admin_access')
    <li class="nav-item mt-3">
      <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">UserManagement</h6>
    </li>
    @endcan
    @can('admin_access')
    <li class="nav-item">
      <a data-bs-toggle="collapse" href="#profileExample" class="nav-link text-white" aria-controls="pagesExamples" role="button" aria-expanded="false">
        <i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">manage_accounts</i>
        <span class="nav-link-text ms-2 ps-1">User Control</span>
      </a>
      <div class="collapse show" id="pagesExamples">
        <ul class="nav">
          <li class="nav-item ">
            <div class="collapse " id="profileExample">
              <ul class="nav nav-sm flex-column">
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.permissions.index')}}">
                    <span class="sidenav-mini-icon"> P </span>
                    <span class="sidenav-normal  ms-2  ps-1"> Permissions </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.roles.index') }}">
                    <span class="sidenav-mini-icon"> U R </span>
                    <span class="sidenav-normal  ms-2  ps-1"> User's Roles </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.users.index')}}">
                    <span class="sidenav-mini-icon"> U </span>
                    <span class="sidenav-normal  ms-2  ps-1"> Users </span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </li>
    @endcan
    {{-- user management --}}

    {{-- wallet management --}}
    @can('admin_access')
    <li class="nav-item mt-3">
      <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">WALLET MANAGEMENT</h6>
    </li>
    @endcan
    @can('admin_access')
    <li class="nav-item">
      <a data-bs-toggle="collapse" href="#extra_profile" class="nav-link text-white" aria-controls="extra" role="button" aria-expanded="false">
        <i class="fas fa-wallet material-icons-round"></i>
        <span class="nav-link-text ms-2 ps-1">Wallet Control</span>
      </a>
      <div class="collapse show" id="extra">
        <ul class="nav">
          <li class="nav-item ">
            <div class="collapse " id="extra_profile">
              <ul class="nav nav-sm flex-column">
                @php
                  $cashIn = App\Models\Admin\CashInRequest::all()->count();
                  $cashOut = App\Models\Admin\CashOutRequest::all()->count();
                @endphp
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.banks.index')}}">
                    <span class="sidenav-mini-icon"> <i class="fas fa-wallet"></i> </span>
                    <span class="sidenav-normal ms-2 ps-1"> Banks </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.cashIn')}}">
                    <span class="sidenav-mini-icon"> <i class="fas fa-wallet"></i> </span>
                    <span class="sidenav-normal  ms-2  ps-1"> Cash In Request <span class="badge text-bg-primary">{{ $cashIn }}</span> </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.cashOut') }}">
                    <span class="sidenav-mini-icon"> <i class="fas fa-wallet"></i> </span>
                    <span class="sidenav-normal  ms-2  ps-1"> Cash Out Request <span class="badge text-bg-primary">{{ $cashOut }}</span>  </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.transferLog')}}">
                    <span class="sidenav-mini-icon"> <i class="fas fa-wallet"></i> </span>
                    <span class="sidenav-normal  ms-2  ps-1"> Transfer Logs </span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </li>
    @endcan
    {{-- wallet management --}}

    {{-- 2d management --}}
    @can('admin_access')
    <li class="nav-item mt-3">
      <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">2D-Management</h6>
    </li>
    @endcan
    @can('admin_access')
    <li class="nav-item">
      <a data-bs-toggle="collapse" href="#twod_profile" class="nav-link text-white" aria-controls="twod" role="button" aria-expanded="false">
        <i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">manage_accounts</i>
        <span class="nav-link-text ms-2 ps-1">2D Control</span>
      </a>
      <div class="collapse show" id="twod">
        <ul class="nav">
          <li class="nav-item ">
            <div class="collapse " id="twod_profile">
              <ul class="nav nav-sm flex-column">
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.role-limits.index')}}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1"> RoleLimitသတ်မှတ်ရန် </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.head-digit-close.index') }}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1"> ထိပ်စီးသုံးလုံးပိတ်ရန် </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.two-digit-close.index') }}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1"> စိတ်ကြိုက်ဂဏန်းပိတ်ရန် </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.morning-lajar') }}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1"> မနက်ပိုင်းလယ်ဂျာ </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.evening-lajar') }}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1"> ညနေပိုင်းလယ်ဂျာ </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.two-d-commission-index') }}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1"> ကော်မစ်ရှင်း </span>
                  </a>
                </li>
                @endcan
                 @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.two-digit-limit.index') }}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1"> Default ဘရိတ်သတ်မှတ်ရန် </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ url('/admin/two-digit-data-morning')}}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1">12:1 မနက်မှတ်တမ်း </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ url('/admin/two-digit-data-afternoon')}}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1">4:30: ညနေမှတ်တမ်း </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ url('/admin/two-digit-data-morning-history')}}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1">12:1: တလမှတ်တမ်း </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ url('/admin/two-digit-data-afternoon-history')}}">
                    <span class="sidenav-mini-icon"> 2D </span>
                    <span class="sidenav-normal  ms-2  ps-1">4:30: တလမှတ်တမ်း </span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </li>
    @endcan
    {{-- 2d management end --}}

    {{-- 3d management --}}
    @can('admin_access')
    <li class="nav-item mt-3">
      <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">3D-Management</h6>
    </li>
    @endcan
    @can('admin_access')
    <li class="nav-item">
      <a data-bs-toggle="collapse" href="#threed_profile" class="nav-link text-white" aria-controls="threed" role="button" aria-expanded="false">
        <i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">manage_accounts</i>
        <span class="nav-link-text ms-2 ps-1">3D Control</span>
      </a>
      <div class="collapse show" id="threed">
        <ul class="nav">
          <li class="nav-item ">
            <div class="collapse " id="threed_profile">
              <ul class="nav nav-sm flex-column">
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.three-digit-limit.index') }}">
                    <span class="sidenav-mini-icon"> 3D </span>
                    <span class="sidenav-normal  ms-2  ps-1"> Default ဘရိတ်သတ်မှတ်ရန် </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.roles.index') }}">
                    <span class="sidenav-mini-icon"> U R </span>
                    <span class="sidenav-normal  ms-2  ps-1"> User's Roles </span>
                  </a>
                </li>
                @endcan
                @can('admin_access')
                <li class="nav-item">
                  <a class="nav-link text-white " href="{{ route('admin.users.index')}}">
                    <span class="sidenav-mini-icon"> U </span>
                    <span class="sidenav-normal  ms-2  ps-1"> Users </span>
                  </a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </li>
    @endcan
    {{-- 3d management end --}}



    <li class="nav-item">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-white">
            <span class="sidenav-mini-icon"> <i class="fas fa-right-from-bracket"></i> </span>
            <span class="sidenav-normal ms-2 ps-1">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>
