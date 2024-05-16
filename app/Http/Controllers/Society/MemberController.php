<?php

namespace App\Http\Controllers\Society;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index()
    {
        $society = Auth::guard('society')->user();
        return view ('society.member.index', compact('society'));
    }



// public function getData(Request $request)
// {
//     if ($request->ajax()) {
//         // Get the currently logged-in society ID
//         $societyId = Auth::guard('society')->id();

//         // Fetch members belonging to the logged-in society
//         $members = Member::with('society')
//             ->where('society_id', $societyId)
//             ->latest()
//             ->get();

//         return DataTables::of($members)
//             ->addIndexColumn()
//             ->addColumn('actions', function($row){
//                 $deleteUrl = route('member.destroy', $row->id);
//                 return '<a href="javascript:void(0)" class="delete-member" data-url="' . $deleteUrl . '">Delete</a>';
//             })
//             ->rawColumns(['actions'])
//             ->make(true);
//     }
// }


    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $members = Member::with('society')->latest()->get();

            return DataTables::of($members)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    $deleteUrl = route('member.destroy', $row->id);
                    return '<a href="javascript:void(0)" class="delete-member" data-url="' . $deleteUrl . '">Delete</a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    // public function getData(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $members = Member::with('society')->latest()->get();

    //         return DataTables::of($members)
    //             ->addIndexColumn()
    //             ->addColumn('actions', function($row){
    //                 $deleteUrl = route('member.destroy', $row->id);
    //                 return '<a href="javascript:void(0)" class="delete-member" data-url="' . $deleteUrl . '">Delete</a>';
    //             })
    //             ->rawColumns(['actions'])
    //             ->make(true);
    //     }
    // }

    public function create()
    {
        $society = Auth::guard('society')->user();
        return view ('society.member._create', compact('society'));
    }

    public function memberImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        // Get the logged-in society
        $society = Auth::guard('society')->user();

        $file = $request->file('file');

        $spreadsheet = IOFactory::load($file);

        $worksheet = $spreadsheet->getActiveSheet();

        $dataArray = $worksheet->toArray(null, true, true, true);

        $headings = array_shift($dataArray);

        $records = [];

        foreach ($dataArray as $row) {
            $record = array_combine($headings, $row);
            $records[] = $record;
        }

        $json_data = json_encode($records);

        $json_file_path = storage_path('app/' . $file->getClientOriginalName() . '.json');
        $jsonData = file_put_contents($json_file_path, $json_data);

        $jsonData = file_get_contents(storage_path('app/' . $file->getClientOriginalName() . '.json'));
        $data = json_decode($jsonData, true);

        foreach ($data as $entry) {
            
            Member::create([
                'name' => $entry['Member Name'],
                'phone' => $entry['Phone'],
                'address' => $entry['Address'],
                'alias' => $entry['Alias'],
                'balance' => $entry['Balance'],
                'total_vouchar' => $entry['Total Vouchar'],
                'society_id' => $society->id,
                'status' => 'Active',
            ]);

        }

        return redirect()->route('member.index')->with('success', __('Member Data Save Successfully.'));

    }

    public function updateStatus(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->status = $request->status;
        $member->save();

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json(['success' => 'Member deleted successfully.']);
    }
}
