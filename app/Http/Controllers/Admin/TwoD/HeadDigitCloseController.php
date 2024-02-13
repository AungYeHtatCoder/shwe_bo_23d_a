<?php

namespace App\Http\Controllers\Admin\TwoD;

use App\Http\Controllers\Controller;
use App\Models\TwoD\HeadDigit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeadDigitCloseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $digits = HeadDigit::all();
        return view('admin.two_d.head_digit.index', compact('digits'));
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
        'digit_one' => 'required|numeric',
        'digit_two' => 'required|numeric',
        'digit_three' => 'required|numeric',

        //'body' => 'required|min:3'
        ]);

    if ($validator->fails()) {
        return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
    }

        // store
        HeadDigit::create([
            'digit_one' => $request->digit_one, 
            'digit_two' => $request->digit_two,
            'digit_three' => $request->digit_three
        ]);
        // redirect
        //Alert::success('Premission has been Created successfully', 'WoW!');
        //toast::success('Success New Permission', 'Permission created successfully.');

        return redirect()->route('admin.head-digit-close.index')->with('toast_success', 'HeadDigit created successfully.');
    

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
        $limit = HeadDigit::findOrFail($id);
        $limit->delete();
        return redirect()->route('admin.head-digit-close.index')->with('toast_success', 'HeadDigit deleted successfully.');
    }
}