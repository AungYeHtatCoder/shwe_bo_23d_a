<?php

namespace App\Http\Controllers\Admin\TwoD;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TwoD\TwodGameResult;
use App\Http\Controllers\Controller;

class TwoGameResultController extends Controller
{
    public function index()
    {
        // Get today's date
        $today = Carbon::now()->format('Y-m-d');

        // Retrieve results for today
        //$results = TwodGameResult::where('result_date', $today)->get();
        // Retrieve results for today where status is 'open'
        $results = TwodGameResult::where('result_date', $today) // Match today's date
                             ->where('status', 'open')      // Check if the status is 'open'
                             ->get();

        // Return the view with the results
        return view('admin.two_d.twod_results.index', ['results' => $results]);
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status'); // The new status

        // Find the result by ID
        $result = TwodGameResult::findOrFail($id);

        // Update the status
        $result->status = $status;
        $result->save();

        // Return a response (like a JSON object)
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }

    public function updateResultNumber(Request $request, $id)
    {
        $result_number = $request->input('result_number'); // The new status

        // Find the result by ID
        $result = TwodGameResult::findOrFail($id);

        // Update the status
        $result->result_number = $result_number;
        $result->save();

        // Return a response (like a JSON object)
        return redirect()->back()->with('success', 'Result number updated successfully.'); // Redirect back with success message
    }
}