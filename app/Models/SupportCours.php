<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportCours extends Model
{
    use HasFactory;

    protected $table = 'supports_cours';

    protected $fillable = [
        'subject_id',
        'subject_name',
        'title',
        'description',
        'file_path',
        'status',
        'created_by',
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        if (empty($this->file_path)) {
            return null;
        }

        return asset('storage/' . $this->file_path);
    }
}

