<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Intern;
use Barryvdh\DomPDF\Facade\Pdf;

class AttestationController extends Controller
{
    /**
     * Noms de mois en français, utilisés car la locale de l'app est 'en'
     * et que Carbon nécessite le package ext-intl / traductions pour le fr.
     */
    private array $mois = [
        1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
        5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
        9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre',
    ];

    private function formatDateFr($date): ?string
    {
        if (empty($date)) {
            return null;
        }

        return $date->day . ' ' . $this->mois[$date->month] . ' ' . $date->year;
    }

    public function stage($id)
    {
        $intern = Intern::getSingle($id);
        if (empty($intern)) {
            abort(404);
        }

        $data = [
            'intern'          => $intern,
            'started_at_fr'   => $this->formatDateFr($intern->started_at),
            'ended_at_fr'     => $this->formatDateFr($intern->ended_at),
            'today_fr'        => $this->formatDateFr(now()),
        ];

        $pdf = Pdf::loadView('admin.attestations.stage', $data)->setPaper('a4');

        return $pdf->stream('attestation-stage-' . str_replace(' ', '-', $intern->name) . '.pdf');
    }

    public function travail($id)
    {
        $employee = Employee::getSingle($id);
        if (empty($employee)) {
            abort(404);
        }

        $data = [
            'employee'   => $employee,
            'hired_at_fr' => $this->formatDateFr($employee->hired_at),
            'today_fr'   => $this->formatDateFr(now()),
        ];

        $pdf = Pdf::loadView('admin.attestations.travail', $data)->setPaper('a4');

        return $pdf->stream('attestation-travail-' . str_replace(' ', '-', $employee->name) . '.pdf');
    }
}
