<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySellings extends Model
{
    use HasFactory;

    protected $table = 'history_sales';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'n_facture',
        'code',
        'product',
        'price',
        'product_cant',
    ];
}
