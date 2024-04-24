<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ThreeD\ResultDate;
use App\Http\Controllers\Controller;

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
    // public function index()
    // {
    //     //$results = ResultDate::all();
    //      $results = ResultDate::where('status', 'open')->get();
    //     return view('admin.three_d.result_date.index', compact('results'));
    // }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status'); // The new status

        // Find the result by ID
        $result = ResultDate::findOrFail($id);

        // Update the status
        $result->status = $status;
        $result->save();

        // Return a response (like a JSON object)
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }
}