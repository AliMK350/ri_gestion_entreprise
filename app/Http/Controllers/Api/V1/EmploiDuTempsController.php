<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EmploiDuTempsController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('emplois_du_temps')) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Emploi du temps module not yet migrated',
            ]);
        }

        $modelClass = 'App\\Models\\EmploiDuTemps';
        if (!class_exists($modelClass)) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $query = $modelClass::query();
        if ($request->user()->user_type == 3) {
            $query->where('student_id', $request->user()->id);
        } elseif ($request->user()->user_type == 2) {
            $query->where('teacher_id', $request->user()->id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('id', 'desc')->get(),
        ]);
    }
}
