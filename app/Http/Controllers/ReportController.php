<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $accounts = Bank::where('is_active', true)->get();
        return view('report.index', compact('accounts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF(Request $request)
    {
        $bank_id = $request->ac_no;
        $frmdt  = $request->from_date;
        $todt = $request->to_date;

        $bank = Bank::where('id', $bank_id)->get()->toArray();
        $data['bank_name'] = $bank[0]['bank_name'];
        $data['ac_no'] = $bank[0]['ac_no'];

        switch ($request->report_type) {
            case ('REC'):

                $rptName = "reconcile.pdf";
                $htm = "report.rpt-unreconcile";

                $query = "SELECT * FROM ledgers WHERE is_reconcile=true AND bank_id=" . $bank_id
                    . " AND issue_date BETWEEN '" . $frmdt . "' AND '" . $todt . "'";
                $data['ledgers'] = DB::select($query);
                break;

            case ('UNREC'):



                $msg = 'Post successfully updated.';

                break;

            default:
                $msg = 'Something went wrong.';
        }

        //return view('report.rpt-unreconcile', compact('data'));

        $pdf = PDF::loadView($htm, $data);

        return $pdf->download($rptName);
    }
}
