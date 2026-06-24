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
        'email',
        'phone',
        'address',
        'status',
        'is_delete',
        'created_by',
    ];

    static public function getClients()
    {
        $return = self::select('clients.*', 'users.name as creator_name')
            ->join('users', 'users.id', '=', 'clients.created_by', 'left')
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
