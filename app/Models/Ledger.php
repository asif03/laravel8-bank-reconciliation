<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'particulars', 'cheque_no', 'issue_date', 'amount', 'entry_type', 'bank_id',
        'excel_upload', 'uploaded_file_id', 'created_by',
    ];
}
