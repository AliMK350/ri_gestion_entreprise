<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploiDuTemps extends Model
{
    use HasFactory;

    protected $table = 'emplois_du_temps';

    protected $fillable = [
        'student_id',
        'class_id',
        'teacher_id',
        'subject_name',
        'jour',
        'heure',
        'salle',
        'date_seance',
    ];
}

