<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank_name', 'branch_name', 'branch_address', 'ac_no', 'ac_title', 'ac_type',
        'remarks', 'is_active', 'created_by', 'updated_by'
    ];
}
