<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $permissions = Permission::all();
        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //dd($request->all());
        $validator = Validator::make($request->all(), [
        'title' => 'required|unique:permissions,title',

        //'body' => 'required|min:3'
    ]);

    if ($validator->fails()) {
        return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
    }

        // store
        Permission::create([
            'title' => $request->title
        ]);
        // redirect
        //Alert::success('Premission has been Created successfully', 'WoW!');
        //toast::success('Success New Permission', 'Permission created successfully.');

        return redirect()->route('admin.permissions.index')->with('toast_success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $permission_detail = Permission::find($id);
        return view('admin.permission.show', compact('permission_detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission_edit = Permission::find($id);
        return view('admin.permission.edit', compact('permission_edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /// validate the request
        $request->validate([
            'title' => 'required|unique:permissions,title,' . $id,
        ]);
        // update
        $permission = Permission::findOrFail($id);
        $permission->update([
            'title' => $request->title
        ]);
        // redirect
        return redirect()->route('admin.permissions.index')->with('toast_success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('toast_success', 'Permission deleted successfully.');
    }
}