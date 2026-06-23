<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CahierTexte extends Model
{
    use HasFactory;

    protected $table = 'cahier_textes';

    protected $fillable = [
        'teacher_id',
        'subject_name',
        'contenu',
        'date_seance',
        'created_by',
    ];
}
