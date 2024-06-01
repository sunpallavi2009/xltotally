<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Role;
use App\Models\Society;
use App\Models\TallyLedger;
use App\Models\TallyCompany;
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
            $societies = TallyCompany::latest()->get();

            return DataTables::of($societies)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('members.index', ['guid' => $row->guid]) . '" class="btn btn-primary">View Members</a>';
                })
                ->make(true);
        }
    }

    public function societyDashboard(Request $request)
    {
        $societyGuid = $request->query('guid');
        $society = TallyCompany::where('guid', 'like', "$societyGuid%")->first();
        // You might want to handle the case when society is not found
        return view('superadmin.society._dashboard', compact('society', 'societyGuid'));
    }
}
