<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ThreeDigit\ThreedClose;
use Illuminate\Support\Facades\Validator;

class ThreeDCloseController extends Controller
{
    public function index()
    {
        $digits = ThreedClose::all();
        return view('admin.three_d.three_d_close.index', compact('digits'));
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
        ThreedClose::create([
            'digit' => $request->digit
        ]);
        return redirect()->route('admin.three-digit-close.index')->with('toast_success', 'CloseThreeDigit created successfully.');
    

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
        $limit = ThreedClose::findOrFail($id);
        $limit->delete();
        return redirect()->route('admin.three-digit-close.index')->with('toast_success', 'CloseThreeDigit deleted successfully.');
    }
}