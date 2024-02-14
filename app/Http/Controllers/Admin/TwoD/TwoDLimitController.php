<?php

namespace App\Http\Controllers\Admin\TwoD;

use Illuminate\Http\Request;
use App\Models\TwoD\TwoDLimit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TwoDLimitController extends Controller
{
    public function index()
    {
       $limits = TwoDLimit::all();
        return view('admin.two_d.two_limit.index', compact('limits'));
    }

     public function store(Request $request)
    {
       //dd($request->all());
        $validator = Validator::make($request->all(), [
        'two_d_limit' => 'required',

        //'body' => 'required|min:3'
    ]);

    if ($validator->fails()) {
        return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
    }

        // store
        TwoDLimit::create([
            'two_d_limit' => $request->two_d_limit
        ]);
        // redirect
        return redirect()->route('admin.two-digit-limit.index')->with('toast_success', 'two_d_limit created successfully.');
    }

    public function destroy($id)
    {
        $limit = TwoDLimit::findOrFail($id);
        $limit->delete();
        return redirect()->route('admin.two-digit-limit.index')->with('toast_success', 'Permission deleted successfully.');
    }

}