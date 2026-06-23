<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('modules')) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Modules not yet migrated',
            ]);
        }

        $modelClass = 'App\\Models\\Module';
        if (!class_exists($modelClass)) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $modelClass::where('is_delete', 0)->orderBy('name')->get(),
        ]);
    }
}
