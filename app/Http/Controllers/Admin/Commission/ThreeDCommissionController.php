<?php

namespace App\Http\Controllers\Admin\Commission;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin\Lottery;
use App\Models\Admin\Commission;
use App\Models\ThreeDigit\Lotto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ThreeDCommissionController extends Controller
{
    public function getThreeDTotalAmountPerUser()
    {
       
    $totalAmounts = Lotto::join('users', 'lottos.user_id', '=', 'users.id')
        ->select([
            DB::raw('MAX(users.name) as name'),
            DB::raw('MAX(users.phone) as phone'),
            DB::raw('MAX(lottos.id) as lottery_id'),
            DB::raw('MAX(lottos.comission) as comission'),
            DB::raw('MAX(lottos.commission_amount) as commission_amount'),
            DB::raw('MAX(lottos.status) as status'),
            'lottos.user_id',
            DB::raw('SUM(lottos.total_amount) as total_amount')
        ])
        ->groupBy('lottos.user_id')
        ->get();
        $commission_percent = Commission::latest()->first();

        //$commission = $commission_percent ? $commission_percent->commission : 0;

         return view('admin.commission.three_d_commission_index',
         [
            'totalAmounts' => $totalAmounts,
           // 'commission_percent' => $commission
        ]);
    }
    public function show($id)
    {
        // Find the Lotto record by its id
        $lotto = Lotto::findOrFail($id);

        // Fetch related user and calculate total amount
        $user = User::join('lottos', 'lottos.user_id', '=', 'users.id')
            ->select('users.name', 'lottos.user_id', 'lottos.id', 'lottos.comission', 'lottos.commission_amount', 'lottos.status', DB::raw('SUM(lottos.total_amount) as total_amount'))
            ->where('lottos.id', $id)
            ->groupBy('lottos.user_id', 'users.name', 'lottos.id', 'lottos.comission', 'lottos.commission_amount', 'lottos.status')
            ->first();

        return view('admin.commission.three_d_commission_show', compact('lotto', 'user'));
    }


public function update(Request $request, $userId)
{
    // Validate the request data
    $validatedData = $request->validate([
        'commission' => 'required|numeric',
        'commission_amount' => 'required|numeric',
        'status' => 'required|string',
    ]);

    // Update records by user_id
    Lotto::where('user_id', $userId)
         ->update([
             'comission' => $validatedData['commission'],
             'commission_amount' => $validatedData['commission_amount'],
             'status' => $validatedData['status'],
         ]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Commissions updated successfully.');
}
    public function ThreeDtransferCommission(Request $request)
{
    Log::info($request->all());
    //dd($request->all());
    // Validate the request
    $validatedData = $request->validate([
        //'lotto_id' => 'required|exists:lottos,id',
        'commission_amount' => 'required|numeric|min:0',
    ]);

    // Start a database transaction
    DB::beginTransaction();

    try {
        $id = $request->lotto_id;
        $lotto = Lotto::findOrFail($id);

        // if ($validatedData['commission'] > $lotto->commission) {
        //     // Make sure we do not transfer more than available commission
        //     return response()->json(['message' => 'Transfer amount exceeds available commission.'], 422);
        // }

        // Find the associated User record
        $user = User::findOrFail($lotto->user_id);

        // Transfer commission
        $user->balance += $validatedData['commission_amount'];
        $lotto->commission_amount -= $validatedData['commission_amount'];

        // Save the changes to the database
        $user->save();
        $lotto->save();

        // Commit the transaction
        DB::commit();

        //return response()->json(['message' => 'Commission transferred successfully.']);
        session()->flash('success', 'Commission transferred successfully.');
        return redirect()->back()->with('success', 'Commission transferred successfully.');
    } catch (\Exception $e) {
    // Rollback the transaction on error
    DB::rollback();
    // Log the exception message
    Log::error($e->getMessage());
    return response()->json(['message' => 'Failed to transfer commission.'], 500);
}
}


}