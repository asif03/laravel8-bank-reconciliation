<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::orderBy('is_active', 'desc')->paginate(10);

        return view('bank.index', ['banks' => $banks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankRequest $request)
    {
        Bank::create(array_merge($request->all(), ['created_by' => auth()->user()->id]));
        return redirect()->back()->with('success', 'Data save successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //dd($bank);
        return view('bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(BankRequest $request, Bank $bank)
    {
        $bank->update(array_merge($request->all(), ['updated_by' => auth()->user()->id]));
        return redirect()->back()->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function active(Bank $bank)
    {

        $bank->update(['is_active' => true]);
        return redirect()->back()->with('success', 'Bank activated successfully.');
    }

    /**
     * Update the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function inactive(Bank $bank)
    {

        $bank->update(['is_active' => false]);
        return redirect()->back()->with('success', 'Bank inactive successfully.');
    }
}
