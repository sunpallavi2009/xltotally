<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Role;
use App\Models\Society;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SocietyController extends Controller
{
    public function index()
    {
        return view ('superadmin.society.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $societies = Society::latest()->get();

            return DataTables::of($societies)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    $editUrl = route('society.edit', $row->id);
                    $deleteUrl = route('society.destroy', $row->id);
                    return '<a href="javascript:void(0)" class="edit-society" data-url="' . $editUrl . '">Edit</a> | 
                            <a href="javascript:void(0)" class="delete-society" data-url="' . $deleteUrl . '">Delete</a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function create()
    {
        return view ('superadmin.society._create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:societies',
        ]);

        Society::create($request->all());

        return redirect()->route('society.index')->with('success', 'Society created successfully.');
    }

    public function edit($id)
    {
        $society = Society::findOrFail($id);
        return view('superadmin.society._edit', compact('society'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
        ]);

        $society = Society::findOrFail($id);
        $society->update($request->all());

        return redirect()->route('society.index')->with('success', 'Society updated successfully.');
    }

    public function destroy($id)
    {
        $society = Society::findOrFail($id);
        $society->delete();

        return response()->json(['success' => 'Society deleted successfully.']);
    }

}
