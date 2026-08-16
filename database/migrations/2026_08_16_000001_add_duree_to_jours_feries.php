<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jours_feries', function (Blueprint $table) {
            if (!Schema::hasColumn('jours_feries', 'duree')) {
                $table->decimal('duree', 5, 2)->default(1)->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jours_feries', function (Blueprint $table) {
            if (Schema::hasColumn('jours_feries', 'duree')) {
                $table->dropColumn('duree');
            }
        });
    }
};
