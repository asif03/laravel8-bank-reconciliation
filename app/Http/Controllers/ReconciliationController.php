<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReconciliationRequest;
use App\Models\Bank;
use App\Models\BankStatement;
use App\Models\Ledger;
use Illuminate\Support\Facades\DB;

class ReconciliationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Bank::where('is_active', true)->get();
        return view('reconciliation.index', ['accounts' => $accounts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reconcile(ReconciliationRequest $request)
    {
        $query = "SELECT lg.id AS lg_id, st.id AS st_id, lg.cheque_no, lg.issue_date, st.trans_date FROM ledgers lg
                    INNER JOIN bank_statements st
                    ON (lg.bank_id=st.bank_id AND lg.cheque_no=st.cheque_no)
                    WHERE lg.is_reconcile=FALSE AND lg.is_active=TRUE AND lg.bank_id=" . $request->ac_no . " 
                        AND lg.issue_date BETWEEN '" . $request->from_date . "' AND '" . $request->to_date . "'";

        $ledgerList = DB::select($query);

        foreach ($ledgerList as $ledger) {
            Ledger::where('id', $ledger->lg_id)
                ->update([
                    'is_reconcile' => TRUE,
                    'reconciliation_date' => $ledger->trans_date,
                    'updated_by' => auth()->user()->id
                ]);

            BankStatement::where('id', $ledger->st_id)
                ->update([
                    'is_reconcile' => TRUE,
                    'updated_by' => auth()->user()->id
                ]);
        }

        return redirect()->back()->with('success', 'Data Reconcile successfully.');
    }

    /**
     * Display a reconciliation statement of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reconStatements()
    {
        $accounts = Bank::where('is_active', true)->get();

        /*SELECT balance FROM
        (SELECT `id`, `amount`, SUM(`amount`) OVER (ORDER BY id) AS balance, RANK() OVER (ORDER BY id DESC) AS sl FROM `ledgers` WHERE `is_active`=TRUE AND `issue_date`<='2021-07-30') AS bal
        WHERE sl=1;*/

        $query = "SELECT lg.id AS lg_id, st.id AS st_id, lg.cheque_no, lg.issue_date, st.trans_date FROM ledgers lg
        INNER JOIN bank_statements st
        ON (lg.bank_id=st.bank_id AND lg.cheque_no=st.cheque_no)
        WHERE lg.is_reconcile=FALSE AND lg.is_active=TRUE AND lg.bank_id=" . $request->ac_no . " 
            AND lg.issue_date BETWEEN '" . $request->from_date . "' AND '" . $request->to_date . "'";

        $ledgerList = DB::select($query);


        return view('reconciliation.statement', ['accounts' => $accounts]);
    }
}
