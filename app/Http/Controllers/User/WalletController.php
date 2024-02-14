<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Bank;
use App\Models\Admin\CashInRequest;
use App\Models\Admin\CashOutRequest;
use App\Models\Admin\TransferLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function wallet()
    {
        return view('user.wallet.wallet');
    }

    public function deposit()
    {
        $banks = Bank::all();
        return view('user.wallet.depositRequest', compact('banks'));
    }

    public function depositBank($id)
    {
        $bank = Bank::find($id);
        return view('user.wallet.deposit', compact('bank'));
    }

    public function depositStore(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'last_6_num' => 'required|max:6|min:6',
            'amount' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);
        CashInRequest::create([
            'payment_method' => $request->payment_method,
            'last_6_num' => $request->last_6_num,
            'amount' => $request->amount,
            'phone' => $request->phone,
            'user_id' => auth()->user()->id,
            'currency' => 'mmk'
        ]);
        TransferLog::create([
            'user_id' => auth()->user()->id,
            'amount' => $request->amount,
            'type' => 'Deposit',
            'created_by' => null
        ]);
        return redirect()->back()->with('success', 'ငွေဖြည့်ဖောင်တင်ပြီးပါပြီ။');
    }

    public function withdraw()
    {
        $banks = Bank::all();
        return view('user.wallet.withdrawRequest', compact('banks'));
    }

    public function withdrawBank($id)
    {
        $bank = Bank::find($id);
        return view('user.wallet.withdraw', compact('bank'));
    }


    public function withdrawStore(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'amount' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);

        if($request->amount > auth()->user()->balance){
            return redirect()->back()->with('error', 'လက်ကျန်ငွေထက် ကျော်လွန်နေပါတယ်။');
        }
        CashOutRequest::create([
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'phone' => $request->phone,
            'name' => $request->name,
            'user_id' => auth()->id(),
            'currency' => 'mmk'
        ]);
        $user = User::find(auth()->id());
        $user->balance -= $request->amount;
        $user->save();
        
        TransferLog::create([
            'user_id' => auth()->user()->id,
            'amount' => $request->amount,
            'type' => 'Withdraw',
            'created_by' => null
        ]);
        return redirect()->back()->with('success', 'ငွေထုတ်ဖောင်တင်ပြီးပါပြီ။');
    }


    public function logs()
    {
        $logs = TransferLog::where('user_id', Auth::user()->id)->latest()->get();
        return view('user.wallet.log', compact('logs'));
    }
}
