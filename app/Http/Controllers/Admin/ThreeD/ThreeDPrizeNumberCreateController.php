<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ThreeDigit\Permutation;
use App\Models\ThreeDigit\ThreeWinner;

class ThreeDPrizeNumberCreateController extends Controller
{
     public function __construct()
    {
        date_default_timezone_set('Asia/Yangon');
    }
    public function index()
    {
        
        $three_digits_prize = ThreeWinner::orderBy('id', 'desc')->first();
        $permutation_digits = Permutation::all();
        return view('admin.three_d.prize_index', compact('three_digits_prize', 'permutation_digits'));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    //$currentSession = date('H') < 12 ? 'morning' : 'evening';  // before 1 pm is morning

        ThreeWinner::create([
            'prize_no' => $request->prize_no,
            //'session' => $currentSession,
        ]);
        session()->flash('SuccessRequest', 'Three Digit Lottery Prize Number Created Successfully');

        return redirect()->back()->with('success', 'Three Digit Lottery Prize Number Created Successfully');
    }

     public function PermutationStore(Request $request)
    {
        // Logic to store permutations in the database
        if ($request->has('permutations')) {
            foreach ($request->permutations as $permutation) {
                Permutation::create(['digit' => $permutation]);
            }
            return redirect()->back()->with('success', 'Permutations stored successfully.');
        } else {
            return redirect()->back()->with('error', 'No permutations to store.');
        }
    }

    // deletePermutation
    public function deletePermutation($id)
    {
        $permutation = Permutation::find($id);
        if ($permutation) {
            $permutation->delete();
            return redirect()->back()->with('success', 'Permutation deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Permutation not found.');
        }
    }

}