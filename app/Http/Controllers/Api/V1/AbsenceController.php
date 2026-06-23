<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AbsenceController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('absences')) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Absences module not yet migrated',
            ]);
        }

        $modelClass = 'App\\Models\\Absence';
        if (!class_exists($modelClass)) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $query = $modelClass::query();
        if ($request->user()->user_type == 3) {
            $query->where('student_id', $request->user()->id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('id', 'desc')->get(),
        ]);
    }
}
