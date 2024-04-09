@extends('layouts.admin_app')
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header pb-0">
                    <div class="d-lg-flex">
                        <div>
                            <h5 class="mb-0">3D Opening Date | Dashboards
                                <span>
                                    <button type="button" class="btn btn-success">
                                        <span>Account Balance</span>
                                        <span class="badge badge-primary">MMK</span>
                                    </button>
                                </span>
                            </h5>

                        </div>
                        <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <div class="ms-auto my-auto">
                                <a href="{{ url('/admin/three-d-list-index') }}"
                                    class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Back To 3D List </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                 <h6>Thai 3D Lottery Match Times for {{ Carbon\Carbon::now()->format('F Y') }}</h6>
                  @if ($matchTime)
        <p>Open Time: {{ $matchTime->open_time }}</p>
        <p>Match Time: {{ $matchTime->match_time }}</p>
    @else
        <p>No match time found for the current period.</p>
    @endif
                 {{-- @if ($matchTime)
                     <p>Open Time: {{ $openTime }}</p>
                     <p>Match Time: {{ $matchTime->match_time }}</p>
                 @else
                     <p>No match times found for the current period.</p>
                 @endif --}}
                 {{-- <table class="table table-flush">
                  <thead>
                      <tr>
                          <th>Open Time</th>
                          <th>Match Time</th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($matchTimes as $time)
                          <tr>
                              <td>{{ $time->open_time }}</td>
                              <td>{{ $time->match_time }}</td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="2">No match times found for the current month.</td>
                          </tr>
                      @endforelse
                  </tbody>
              </table> --}}
               {{-- @if ($matchTimes->isNotEmpty())
                   @foreach ($matchTimes as $time)
                       <div class="alert alert-info" role="alert">
                           {{ $time->match_time }}
                       </div>
                   @endforeach
               @else
                   <div class="alert alert-warning" role="alert">
                       No match times found for the current month.
                   </div>
               @endif --}}
               {{-- @if ($existingMatchTime)
                       <div class="alert alert-success" role="alert">
                           The match time for the current period is: {{ $existingMatchTime->match_time }}
                       </div>
                   @else
                       <div class="alert alert-warning" role="alert">
                           No match time found for the current period.
                       </div>
                   @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection
