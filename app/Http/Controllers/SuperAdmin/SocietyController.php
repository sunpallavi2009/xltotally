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

}
