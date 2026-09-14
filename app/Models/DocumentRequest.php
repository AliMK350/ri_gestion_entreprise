<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    public const TYPES = [
        'Attestation de travail',
        'Attestation de salaire',
        'Attestation de stage',
        'Certificat de travail',
        'Bulletin de salaire',
        'Demande de congé administratif',
        'Autre document administratif',
    ];

    protected $fillable = [
        'employee_id', 'document_type', 'reason', 'status', 'admin_response', 'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
