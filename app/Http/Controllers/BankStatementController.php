<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankStatementRequest;
use App\Imports\BankStatementImport;
use App\Models\Bank;
use App\Models\BankStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BankStatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Bank::where('is_active', true)->get();
        return view('statement.index', compact('accounts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatementData($id, $frmdt, $todt)
    {
        $query = "SELECT * FROM `bank_statements` WHERE bank_id=" . $id . " AND trans_date BETWEEN '" . $frmdt . "' AND '" . $todt . "' ORDER BY trans_date ASC";
        $data = DB::select($query);
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Bank::where('is_active', true)->get();
        return view('statement.create', ['accounts' => $accounts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankStatementRequest $request)
    {
        //dd($request->all());
        if ($request->entry_type === 'dr.') {
            $data['dr_amount'] = $request->amount;
        }
        if ($request->entry_type === 'cr.') {
            $data['cr_amount'] = $request->amount;
        }
        $data['created_by'] = auth()->user()->id;

        BankStatement::create(array_merge($request->all(), $data));
        return redirect()->back()->with('success', 'Data save successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankStatement  $bankStatement
     * @return \Illuminate\Http\Response
     */
    public function show(BankStatement $bankStatement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankStatement  $bankStatement
     * @return \Illuminate\Http\Response
     */
    public function edit(BankStatement $bankStatement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankStatement  $bankStatement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankStatement $bankStatement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankStatement  $bankStatement
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankStatement $bankStatement)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bankStatFileImport()
    {
        $accounts = Bank::where('is_active', true)->get();
        return view('statement.statement-file-import', ['accounts' => $accounts]);
    }

    /**
     * Store a bank statement excel in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function statementExcelImport(Request $request)
    {
        $bank_id = $request->ac_no;
        $created_by = auth()->id();

        $file_path = $request->file('execl_file')->store('excels');
        $file_name = $request->file('execl_file')->getClientOriginalName();
        $file_extension = $request->file('execl_file')->extension();

        $file_id = DB::table('uploads')->insertGetId([
            'file_name' => $file_name,
            'file_desc' => $file_extension,
            'file_type' => 'BST',
            'file_path' => $file_path,
            'created_by' => $created_by,
        ]);

        if ($file_id) {
            Excel::import(new BankStatementImport($bank_id, $created_by, $file_id), $request->file('execl_file')
                ->store('temp'));

            return redirect()->back()->with('success', 'Data uploaded successfully.');
        }

        return redirect()->back()->with('error', 'Woops! Error occurs to uploading file.');
    }
}
