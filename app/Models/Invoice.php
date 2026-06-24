<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'client_id', 'quote_id', 'reference', 'amount', 'issued_at', 'due_at', 'paid', 'status', 'details',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'due_at'    => 'date',
        'paid'      => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
