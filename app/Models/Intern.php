<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Intern extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'department', 'cv_path', 'started_at', 'ended_at',
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at'   => 'date',
    ];

    static public function getInterns()
    {
        $return = self::query();

        if (!empty(Request::get('name'))) {
            $return = $return->where('name', 'like', '%' . Request::get('name') . '%');
        }
        if (!empty(Request::get('department'))) {
            $return = $return->where('department', 'like', '%' . Request::get('department') . '%');
        }

        return $return->orderBy('id', 'desc')->paginate(10);
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
