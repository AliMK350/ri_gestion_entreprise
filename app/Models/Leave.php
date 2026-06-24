<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Leave extends Model
{
    protected $fillable = [
        'employee_id', 'start_date', 'end_date', 'type', 'status', 'reason',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    static public function getLeaves()
    {
        $return = self::with('employee');

        if (!empty(Request::get('status'))) {
            $return = $return->where('status', Request::get('status'));
        }

        return $return->orderBy('created_at', 'desc')->paginate(10);
    }
}
