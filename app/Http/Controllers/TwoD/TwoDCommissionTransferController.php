<?php

namespace App\Http\Controllers\TwoD;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TwoDCommissionTransferController extends Controller
{
   

public function TwodCommissiontransferToMain(Request $request)
{
    $user = Auth::user();
    $corAmount = $user->cor;

    // Begin a transaction
    DB::beginTransaction();
    try {
        // Add the cor amount to balance
        $user->increment('balance', $corAmount);
        // Reset the cor amount to 0
        $user->cor = 0;
        $user->save();

        DB::commit();
        return back()->with('success', 'Amount transferred successfully to main balance.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'An error occurred during the transfer.');
    }
}

}