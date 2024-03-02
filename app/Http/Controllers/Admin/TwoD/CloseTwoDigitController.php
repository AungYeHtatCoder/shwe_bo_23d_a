<?php

namespace App\Http\Controllers\Admin\TwoD;

use Illuminate\Http\Request;
use App\Models\TwoD\CloseTwoDigit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CloseTwoDigitController extends Controller
{
   public function index()
    {
        $digits = CloseTwoDigit::all();
        return view('admin.two_d.two_digit_close.index', compact('digits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
        'digit' => 'required|numeric',
        ]);

    if ($validator->fails()) {
        return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
    }

        // store
        CloseTwoDigit::create([
            'digit' => $request->digit
        ]);
        return redirect()->route('admin.two-digit-close.index')->with('toast_success', 'CloseTwoDigit created successfully.');
    

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
 public function destroy($id)
    {
        $limit = CloseTwoDigit::findOrFail($id);
        $limit->delete();
        return redirect()->route('admin.two-digit-close.index')->with('toast_success', 'CloseTwoDigit deleted successfully.');
    }
}