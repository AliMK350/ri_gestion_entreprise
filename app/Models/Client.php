<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'company_name',
        'client_type',
        'email',
        'phone',
        'address',
        'city',
        'status',
        'is_delete',
        'created_by',
    ];

    static public function getClients()
    {
        $return = self::select('clients.*')
            ->where('clients.is_delete', '=', 0);

        if (!empty(Request::get('name'))) {
            $return = $return->where('clients.name', 'like', '%' . Request::get('name') . '%');
        }
        if (!empty(Request::get('company_name'))) {
            $return = $return->where('clients.company_name', 'like', '%' . Request::get('company_name') . '%');
        }
        if (!empty(Request::get('email'))) {
            $return = $return->where('clients.email', 'like', '%' . Request::get('email') . '%');
        }
        if (!empty(Request::get('city'))) {
            $return = $return->where('clients.city', 'like', '%' . Request::get('city') . '%');
        }
        if (!empty(Request::get('client_type'))) {
            $return = $return->where('clients.client_type', '=', Request::get('client_type'));
        }
        $return = $return->orderBy('clients.id', 'desc')->paginate(10);

        return $return;
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
