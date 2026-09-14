<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Intern extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'specialite', 'city', 'niveau_etude', 'cv_path', 'started_at', 'ended_at',
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
        if (!empty(Request::get('specialite'))) {
            $return = $return->where('specialite', 'like', '%' . Request::get('specialite') . '%');
        }

        return $return->orderBy('id', 'desc')->paginate(10);
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
