<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploads extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name', 'file_desc', 'file_type', 'file_path', 'created_by', 'updated_by',
    ];
}
