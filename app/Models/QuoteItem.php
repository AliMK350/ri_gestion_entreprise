<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $table = 'quote_items';

    protected $fillable = [
        'quote_id',
        'designation',
        'description',
        'quantity',
        'unit',
        'unit_price_ht',
        'tva_rate',
        'total_ht',
        'total_tva',
        'total_ttc',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
