<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Employee extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'position', 'department', 'hired_at', 'status', 'leave_balance_days',
    ];

    protected $casts = [
        'hired_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    static public function getEmployees()
    {
        $return = self::query();

        if (!empty(Request::get('name'))) {
            $return = $return->where('name', 'like', '%' . Request::get('name') . '%');
        }
        if (!empty(Request::get('email'))) {
            $return = $return->where('email', 'like', '%' . Request::get('email') . '%');
        }
        if (Request::get('status') !== null && Request::get('status') !== '') {
            $return = $return->where('status', Request::get('status'));
        }

        return $return->orderBy('id', 'desc')->paginate(10);
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function forUser($userId)
    {
        return self::where('user_id', $userId)->first();
    }
}
