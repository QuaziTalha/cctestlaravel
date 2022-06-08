<?php

namespace App\Http\Controllers\Admin\SchoolsApprovals;

use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SchoolApprovalController extends Controller
{
    //  --- === Schools Approvals View Function === --- \\
    public function SchoolsApprovals()
    {
        return view('Admin.SchoolsApprovals.SchoolApprovals');
    }
    //  --- === Schools Approvals View Function === --- \\

    // --- === Get School List Data  === --- \\
    public function GetSchoolList()
    {
        $data = DB::table('p_schools')
            // ->where(function ($query) use ($from_date, $to_date) {
            //     if ($from_date != "" && $to_date != "") {
            //         $query->whereBetween('transaction_date', [$from_date, $to_date]);
            //     }
            // })
            // ->orderBy('school_id ', 'DESC')
            ->get();
        return Datatables::of($data)->addColumn('action', function ($data) {
            return '<button type="button" class="ms-btn-icon btn-pill btn-warning mr-1" onclick="GroupEdit(' . $data->school_id . ')"><i class="flaticon-pencil mr-0"></i></button>';
        })
        ->make(true);
    }
    // --- === Get School List Data  === --- \\
}