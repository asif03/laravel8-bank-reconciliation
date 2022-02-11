<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\BankStatementController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\ReconciliationController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('banks', BankController::class)->middleware(['auth']);
Route::put('/banks/{bank}/inactive', [BankController::class, 'inactive'])->middleware(['auth'])->name('bank.inactive');
Route::put('/banks/{bank}/active', [BankController::class, 'active'])->middleware(['auth'])->name('bank.active');

Route::resource('ledgers', LedgerController::class)->middleware(['auth']);
Route::get('/get-ledger-data/{id}/{fmdt}/{tdt}', [LedgerController::class, 'getLedgerData'])->middleware(['auth'])->name('get-ledger-data');
Route::get('/ledger/import', [LedgerController::class, 'ledgerFileImport'])->middleware(['auth'])->name('ledgers.import');
Route::post('/ledger/import-create', [LedgerController::class, 'ledgerExcelImport'])->middleware(['auth'])->name('ledgers.import-create');

Route::resource('statements', BankStatementController::class)->middleware(['auth']);
Route::get('/get-statement-data/{id}/{fmdt}/{tdt}', [BankStatementController::class, 'getStatementData'])->middleware(['auth'])->name('get-statement-data');
Route::get('/statement/import', [BankStatementController::class, 'bankStatFileImport'])->middleware(['auth'])->name('statements.import');
Route::post('/statement/import-create', [BankStatementController::class, 'statementExcelImport'])->middleware(['auth'])->name('statements.import-create');

Route::get('/reconciliation', [ReconciliationController::class, 'index'])->middleware(['auth'])->name('reconciliation.index');
Route::post('/reconciliation/recon', [ReconciliationController::class, 'reconcile'])->middleware(['auth'])->name('reconciliation.recon');
Route::get('/recon-statement', [ReconciliationController::class, 'reconStatements'])->middleware(['auth'])->name('reconciliation.statement');

Route::get('/reports', [ReportController::class, 'index'])->middleware('auth')->name('reports.index');
Route::post('/generate-pdf', [ReportController::class, 'generatePDF'])->middleware('auth')->name('reports.generate-pdf');

require __DIR__ . '/auth.php';
