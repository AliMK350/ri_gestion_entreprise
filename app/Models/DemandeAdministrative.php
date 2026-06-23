<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeAdministrative extends Model
{
    use HasFactory;

    protected $table = 'demande_administratives';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'objet',
        'message',
        'statut',
        'response',
        'response_file',
        'processed_by',
    ];
}

