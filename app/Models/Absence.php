<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = [
        'employee_id', 'declared_by', 'date', 'half_day', 'reason', 'justification_file',
    ];

    public function isDeclaredByAdmin(): bool
    {
        return $this->declared_by === 'admin';
    }

    public function needsEmployeeJustification(): bool
    {
        return $this->isDeclaredByAdmin()
            && (empty($this->reason) || empty($this->justification_file));
    }

    protected $casts = [
        'date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
