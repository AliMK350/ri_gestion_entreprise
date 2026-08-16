<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';

    protected $fillable = [
        'client_id',
        'employee_id',
        'seller_id',
        'reference',
        'quote_date',
        'validity_date',
        'payment_conditions',
        'notes',
        'total_ht',
        'total_tva',
        'total_ttc',
        'total_amount',
        'status',
        'details',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class, 'quote_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
