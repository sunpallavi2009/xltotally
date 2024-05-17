<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view ('superadmin.roles.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::latest()->get();

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    $editUrl = route('roles.edit', $row->id);
                    $deleteUrl = route('roles.destroy', $row->id);
                    return '<a href="javascript:void(0)" class="edit-role" data-url="' . $editUrl . '">Edit</a> | 
                            <a href="javascript:void(0)" class="delete-role" data-url="' . $deleteUrl . '">Delete</a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function create()
    {
        return view ('superadmin.roles._create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('superadmin.roles._edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['success' => 'Role deleted successfully.']);
    }
}
