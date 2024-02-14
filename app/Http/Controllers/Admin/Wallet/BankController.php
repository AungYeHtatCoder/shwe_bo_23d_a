<?php

namespace App\Http\Controllers\Admin\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Admin\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = Bank::latest()->get();
        return view('admin.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        // image
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $filename = uniqid('bank') . '.' . $ext; // Generate a unique filename
        $image->move(public_path('assets/img/banks/'), $filename); // Save the file

        Bank::create([
            'bank' => $request->bank,
            'image' => $filename,
            'name' => $request->name,
            'phone' => $request->phone,
            'currency' => 'mmk'
        ]);
        return redirect()->route('admin.banks.index')->with('success', 'Bank created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        return view('admin.banks.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'bank' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);
        if($request->hasFile('image')){
            //remove bank from localstorage
            File::delete(public_path('assets/img/banks/' . $bank->image));
            // image
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $filename = uniqid('bank') . '.' . $ext; // Generate a unique filename
            $image->move(public_path('assets/img/banks/'), $filename); // Save the file
        }else{
            $filename = $bank->image;
        }
        $bank->update([
            'bank' => $request->bank,
            'image' => $filename,
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        return redirect()->route('admin.banks.index')->with('success', 'Bank updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        File::delete(public_path('assets/img/banks/' . $bank->image));
        $bank->delete();
        return redirect()->route('admin.banks.index')->with('success', 'Bank deleted successfully');
    }
}
