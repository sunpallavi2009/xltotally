<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\TallyLedger;
use App\Models\TallyCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $societyGuid = $request->query('guid');
        $group = $request->query('group', 'Sundry Debtors'); // default to 'Sundry Debtors' if not provided
        $society = TallyCompany::where('guid', 'like', "$societyGuid%")->get();
        return view('superadmin.bills.index', compact('society', 'societyGuid', 'group'));
    }
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $societyGuid = $request->query('guid');
            $group = $request->query('group');
    
            $society = TallyCompany::where('guid', 'like', "$societyGuid%")->first();
    
            if (!$society) {
                return response()->json(['message' => 'Society not found'], 404);
            }
    
            $query = TallyLedger::where('guid', 'like', $society->guid . '%');
    
            // if ($group == 'Sundry Debtors') {
            //     $query->where('primary_group', 'Sundry Debtors')
            //           ->whereNotNull('alias1')
            //           ->where('alias1', '!=', '');
            // } else {
            //     $query->where('primary_group', '!=', 'Sundry Debtors');
            // }
    
            $members = $query->withCount('vouchers')
                ->with('vouchers')
                ->latest()
                ->get()
                ->map(function($member) {
                    $member->first_voucher_date = $member->firstVoucherDate();
                    return $member;
                });
    
            return DataTables::of($members)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
