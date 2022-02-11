<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankStatement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'particulars', 'cheque_no', 'trans_date', 'dr_amount', 'cr_amount', 'balance',
        'entry_type', 'bank_id', 'excel_upload', 'uploaded_file_id', 'created_by', 'updated_by'
    ];
}
