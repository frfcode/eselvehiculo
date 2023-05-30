<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $table = 'billing';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id',
        'vendor',
        'client',
        'iva',
        'total_price',
    ];
}
