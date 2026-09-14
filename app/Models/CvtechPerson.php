<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvtechPerson extends Model
{
    protected $fillable = [
        'person_type', 'source_type', 'source_id', 'name', 'email', 'phone',
        'city', 'specialite', 'position', 'niveau_etude', 'started_at',
        'ended_at', 'hired_at', 'notes', 'cv_path',
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at'   => 'date',
        'hired_at'   => 'date',
    ];

    public static function syncEmployee(Employee $employee): self
    {
        return self::updateOrCreate(
            ['source_type' => 'employee', 'source_id' => $employee->id],
            [
                'person_type'  => 'employee',
                'name'         => $employee->name,
                'email'        => $employee->email,
                'phone'        => $employee->phone,
                'city'         => $employee->city,
                'specialite'   => $employee->specialite,
                'position'     => $employee->position,
                'hired_at'     => $employee->hired_at,
                'cv_path'      => $employee->cv_path,
            ]
        );
    }

    public static function syncIntern(Intern $intern): self
    {
        return self::updateOrCreate(
            ['source_type' => 'intern', 'source_id' => $intern->id],
            [
                'person_type'  => 'intern',
                'name'         => $intern->name,
                'email'        => $intern->email,
                'phone'        => $intern->phone,
                'city'         => $intern->city,
                'specialite'   => $intern->specialite,
                'niveau_etude' => $intern->niveau_etude,
                'started_at'   => $intern->started_at,
                'ended_at'     => $intern->ended_at,
                'cv_path'      => $intern->cv_path,
            ]
        );
    }
}
