<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ThreeD\ResultDate;
use App\Http\Controllers\Controller;
use App\Models\ThreeDigit\LotteryThreeDigitPivot;

class ResultDateController extends Controller
{
    public function index()
{
    // Get the start and end dates for the current month
    $currentMonthStart = Carbon::now()->startOfMonth();
    $currentMonthEnd = Carbon::now()->endOfMonth();

    // Get the start and end dates for the next month
    $nextMonthStart = Carbon::now()->addMonth()->startOfMonth();
    $nextMonthEnd = Carbon::now()->addMonth()->endOfMonth();

    // Fetch results with status 'open' or 'closed' within these date ranges
    $results = ResultDate::whereIn('status', ['open', 'closed'])
        ->where(function ($query) use ($currentMonthStart, $currentMonthEnd, $nextMonthStart, $nextMonthEnd) {
            $query->whereBetween('result_date', [$currentMonthStart, $currentMonthEnd])
                  ->orWhereBetween('result_date', [$nextMonthStart, $nextMonthEnd]);
        })
        ->get();

    return view('admin.three_d.result_date.index', compact('results'));
}

    public function updateStatus(Request $request, $id)
{
    // Get the new status with a fallback default
    $newStatus = $request->input('status', 'closed'); // Default to 'closed' if not provided
    
    // Find the existing record and update the status
    $result = ResultDate::findOrFail($id);

    // Ensure the status is not NULL before updating
    if (is_null($newStatus)) {
        return redirect()->back()->with('error', 'Status cannot be null');
    }

    $result->status = $newStatus;
    $result->save();

    return redirect()->back()->with('success', "Status changed to '{$newStatus}' successfully.");
}

    public function AdminLogThreeDOpenClose(Request $request, $id)
{
    // Get the new status with a fallback default
    $newStatus = $request->input('admin_log', 'closed'); // Default to 'closed' if not provided
    
    // Find the existing record and update the status
    $result = LotteryThreeDigitPivot::findOrFail($id);

    // Ensure the status is not NULL before updating
    if (is_null($newStatus)) {
        return redirect()->back()->with('error', 'Admin Log cannot be null');
    }

    $result->admin_log = $newStatus;
    $result->save();

    return redirect()->back()->with('success', "Admin Log changed to '{$newStatus}' successfully.");
}

    public function UserLogThreeDOpenClose(Request $request, $id)
{
    // Get the new status with a fallback default
    $newStatus = $request->input('user_log', 'closed'); // Default to 'closed' if not provided
    
    // Find the existing record and update the status
    $result = ResultDate::findOrFail($id);

    // Ensure the status is not NULL before updating
    if (is_null($newStatus)) {
        return redirect()->back()->with('error', 'User Log cannot be null');
    }

    $result->user_log = $newStatus;
    $result->save();

    return redirect()->back()->with('success', "User Log changed to '{$newStatus}' successfully.");
}

    // public function updateStatus(Request $request, $id)
    // {
    //       $newStatus = $request->input('status');

    //         // Find the existing record and update the status
    //         $result = ResultDate::findOrFail($id);
    //         $result->status = $newStatus;
    //         $result->save();

    //         return redirect()->back()->with('success', "Status changed to '{$newStatus}' successfully.");
    //     // $status = $request->input('status'); // The new status

    //     // // Find the result by ID
    //     // $result = ResultDate::findOrFail($id);

    //     // // Update the status
    //     // $result->status = $status;
    //     // $result->save();

    //     // // Return a response (like a JSON object)
    //     // return response()->json([
    //     //     'success' => true,
    //     //     'message' => 'Status updated successfully.',
    //     // ]);
    // }
    public function updateResultNumber(Request $request, $id)
    {
        $result_number = $request->input('result_number'); // The new status

        // Find the result by ID
        $result = ResultDate::findOrFail($id);

        // Update the status
        $result->result_number = $result_number;
        $result->save();

        // Return a response (like a JSON object)
        return redirect()->back()->with('success', 'Result number updated successfully.'); // Redirect back with success message
    }
}