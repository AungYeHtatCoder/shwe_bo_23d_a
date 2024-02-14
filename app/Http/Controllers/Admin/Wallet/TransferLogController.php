<?php

namespace App\Http\Controllers\Admin\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Admin\TransferLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferLogController extends Controller
{
    public function index()
    {
        $logs = TransferLog::latest()->get();
        return view('admin.cash_requests.transferlog', compact('logs'));
    }

}
