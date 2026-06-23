<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JustificatifAbsence extends Model
{
    use HasFactory;

    protected $table = 'justificatif_absences';

    protected $fillable = [
        'student_id',
        'absence_id',
        'file_path',
        'commentaire',
        'statut',
        'validated_by',
    ];

    protected $appends = ['file_name', 'file_url'];

    public function getFileNameAttribute()
    {
        return empty($this->file_path) ? null : basename($this->file_path);
    }

    public function getFileUrlAttribute()
    {
        if (empty($this->file_path)) {
            return null;
        }

        return asset('storage/' . $this->file_path);
    }
}

