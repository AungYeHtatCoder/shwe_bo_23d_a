<?php

namespace App\Http\Controllers\Admin\ThreeD;

use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ThreeDigit\ThreeRoleLimit;
use Illuminate\Support\Facades\Validator;

class ThreeDRoleLimitController extends Controller
{
    public function index()
    {
       $limits = ThreeRoleLimit::all();
       $roles = Role::all();
        return view('admin.three_d.three_d_role_limit.index', compact('limits', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.three_d.three_d_role_limit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //dd($request->all());
        $validator = Validator::make($request->all(), 
        [
        'role_id' => 'required|exists:roles,id',
        'limit' => 'required|unique:role_limits,limit',

        //'body' => 'required|min:3'
        ]);

    if ($validator->fails()) {
        return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
    }

        // store
        ThreeRoleLimit::create([
            'role_id' => $request->role_id, // 
            'limit' => $request->limit
        ]);
        // redirect
        //Alert::success('Premission has been Created successfully', 'WoW!');
        //toast::success('Success New Permission', 'Permission created successfully.');

        return redirect()->route('admin.three-d-role-limits.index')->with('toast_success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $limit_detail = ThreeRoleLimit::find($id);
        return view('admin.three_d_three_d_role_limit.show', compact('limit_detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $roles = Role::all()->pluck('title', 'id');
        $limit_edit = ThreeRoleLimit::find($id);
        return view('admin.three_d.three_d_role_limit.edit', compact('limit_edit', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /// validate the request
        $request->validate([
            'limit' => 'required|unique:role_limits,limit,' . $id,
        ]);
        // update
        $permission = ThreeRoleLimit::findOrFail($id);
        $permission->update([
            'limit' => $request->limit
        ]);
        // redirect
        return redirect()->route('admin.three-d-role-limits.index')->with('toast_success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $limit = ThreeRoleLimit::findOrFail($id);
        $limit->delete();
        return redirect()->route('admin.three-d-role-limits.index')->with('toast_success', 'RoleLimit deleted successfully.');
    }
}