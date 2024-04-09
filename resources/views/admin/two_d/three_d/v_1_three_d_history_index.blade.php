@extends('layouts.admin_app')
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header pb-0">
                    <div class="d-lg-flex">
                        <div>
                            <h5 class="mb-0">3D History Detail | Dashboards
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
                                <a href="{{ route('admin.twod-records.index') }}"
                                    class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Back To 2D List </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-flush">
                         <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Lottery Match</th>
                <th>Total Bet Amount</th>
                <th>Bet Digit & Bet Amount</th>
                <th>Match Times</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($threedLotteries as $lottery)
                <tr>
                    <td>{{ $lottery->id }}</td>
                    <td>{{ $lottery->user->name }}</td>
                    <td>{{ $lottery->lotteryMatch->id }}</td>
                    <td>{{ $lottery->total_amount }}</td>
                    <td>
                        @foreach ($lottery->entries as $entry)
                            Entry ID: {{ $entry->id }}, Digit: {{ $entry->digit_entry }}, ထိုးကြေး : 
                            <span class="badge text-bg-success">
                                {{ $entry->sub_amount }}
                            </span>
                            <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($lottery->threedMatchTimes as $matchTime)
                            အကြိမ်ရေ : <span class="bage badge-primary">
                            {{ $matchTime->id }}    
                            </span>, ဖွင့်မည့်ရက် : 
                            <span class="badge badge-info">
                                {{ $matchTime->match_time }}
                            </span>
                            <br>
                        @endforeach
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
