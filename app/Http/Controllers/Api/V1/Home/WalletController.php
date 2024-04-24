<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin\CashInRequest;
use App\Models\Admin\CashOutRequest;
use App\Models\Admin\TransferLog;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    use HttpResponses;
    public function cashInRequest(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'payment_method' => 'required',
            'amount' => 'required',
            'phone' => 'required',
            "last_6_num" => 'required|max:6',
        ]);
        
        $req = CashInRequest::create([
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'phone' => $request->phone,
            "last_6_num" => $request->last_6_num,
            'user_id' => Auth::id(),
        ]);
        TransferLog::create([
            'user_id' => $req->user_id,
            'amount' => $req->amount,
            'type' => 'Deposit',
        ]);
        return $this->success($req, 'Cash in request sent successfully.');
    }

    public function cashOutRequest(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'amount' => 'required',
            'phone' => 'required',
            "name" => 'required',
        ]);
        $req = CashOutRequest::create([
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'phone' => $request->phone,
            "name" => $request->name,
            'user_id' => Auth::id(),
        ]);
        TransferLog::create([
            'user_id' => $req->user_id,
            'amount' => $req->amount,
            'type' => 'Withdraw',
        ]);
        return $this->success($req, 'Cash out request sent successfully.');
    }

    public function transferLogs()
    {
        $logs = TransferLog::latest()->paginate(10);
        return $this->success($logs, 'Transfer logs.');
    }
}
