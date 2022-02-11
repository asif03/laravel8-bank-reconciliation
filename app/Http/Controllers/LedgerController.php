<?php

namespace App\Http\Controllers;

use App\Http\Requests\LedgerRequest;
use App\Imports\LedgerImport;
use App\Models\Bank;
use App\Models\Ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Bank::where('is_active', true)->get();
        return view('ledger.index', ['accounts' => $accounts]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLedgerData($id, $frmdt, $todt)
    {
        $query = "SELECT * FROM `ledgers` WHERE bank_id=" . $id . " AND issue_date BETWEEN '" . $frmdt . "' AND '" . $todt . "'";
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
        return view('ledger.create', ['accounts' => $accounts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LedgerRequest $request)
    {
        Ledger::create(array_merge($request->all(), ['created_by' => auth()->user()->id]));
        return redirect()->back()->with('success', 'Data save successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger $ledger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function edit(Ledger $ledger)
    {
        $accounts = Bank::where('is_active', true)->get();
        return view('ledger.edit', compact('accounts', 'ledger'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function update(LedgerRequest $request, Ledger $ledger)
    {
        $query = "SELECT id FROM ledgers WHERE is_reconcile=true AND id=" . $ledger->id;
        $ledgerList = DB::select($query);
        if (count($ledgerList) > 0) {
            return redirect()->back()->with('error', 'Update is not possible in case of reconcile data.');
        }

        $ledger->update(array_merge($request->all(), ['updated_by' => auth()->user()->id]));
        return redirect()->back()->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    //public function destroy(Ledger $ledger)
    public function destroy($id)
    {
        $ledger = Ledger::find($id);
        $ledger->delete();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ledgerFileImport()
    {
        $accounts = Bank::where('is_active', true)->get();
        return view('ledger.ledger-file-import', ['accounts' => $accounts]);
    }

    /**
     * Store a ledger excel in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ledgerExcelImport(Request $request)
    {
        $bank_id = $request->ac_no;
        $created_by = auth()->id();

        $file_path = $request->file('execl_file')->store('excels');
        $file_name = $request->file('execl_file')->getClientOriginalName();
        $file_extension = $request->file('execl_file')->extension();

        $file_id = DB::table('uploads')->insertGetId([
            'file_name' => $file_name,
            'file_desc' => $file_extension,
            'file_type' => 'LED',
            'file_path' => $file_path,
            'created_by' => $created_by,
        ]);

        if ($file_id) {

            Excel::import(new LedgerImport($bank_id, $created_by, $file_id), $request->file('execl_file')
                ->store('temp'));

            return redirect()->back()->with('success', 'Data uploaded successfully.');
        }

        return redirect()->back()->with('error', 'Data not uploaded.');
    }
}
