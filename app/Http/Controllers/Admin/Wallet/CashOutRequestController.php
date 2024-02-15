<?php

namespace App\Http\Controllers\Admin\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Admin\CashOutRequest;
use App\Models\Admin\TransferLog;
use App\Models\User;
use Illuminate\Http\Request;

class CashOutRequestController extends Controller
{
    public function index()
    {
        $cashes = CashOutRequest::latest()->get();
        return view('admin.cash_requests.cash_out', compact('cashes'));
    }



    public function show($id)
    {
        $cash = CashOutRequest::find($id);
        return view('admin.cash_requests.cash_out_detail', compact('cash'));
    }

    public function accept($id)
    {
        $cash = CashOutRequest::find($id);
        $cash->status = 1;
        $cash->save();

        $log = TransferLog::where('user_id', $cash->user_id)
        ->where('created_at', $cash->created_at)
        ->first();

        $log->update([
            'status' => 1,
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->back()->with('toast_success', 'Filled the cash into user successfully');
    }

    public function reject($id)
    {
        $cash = CashOutRequest::find($id);
        $currency = $cash->currency;
        $amount = $cash->amount;
        User::where('id', $cash->user_id)->increment('balance', $amount);

        $cash->status = 2;
        $cash->save();

        $log = TransferLog::where('user_id', $cash->user_id)
        ->where('created_at', $cash->created_at)
        ->first();

        $log->update([
            'status' => 2,
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->back()->with('toast_success', 'Filled the cash into user successfully');
    }
}
