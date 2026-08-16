<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            if (!Schema::hasColumn('quotes', 'quote_date')) {
                $table->date('quote_date')->nullable()->after('client_id');
            }
            if (!Schema::hasColumn('quotes', 'seller_id')) {
                $table->foreignId('seller_id')->nullable()->after('quote_date')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('quotes', 'validity_date')) {
                $table->string('validity_date')->nullable()->after('reference');
            }
            if (!Schema::hasColumn('quotes', 'payment_conditions')) {
                $table->text('payment_conditions')->nullable()->after('validity_date');
            }
            if (!Schema::hasColumn('quotes', 'notes')) {
                $table->text('notes')->nullable()->after('payment_conditions');
            }
            if (!Schema::hasColumn('quotes', 'total_ht')) {
                $table->decimal('total_ht', 12, 2)->default(0)->after('total_amount');
            }
            if (!Schema::hasColumn('quotes', 'total_tva')) {
                $table->decimal('total_tva', 12, 2)->default(0)->after('total_ht');
            }
            if (!Schema::hasColumn('quotes', 'total_ttc')) {
                $table->decimal('total_ttc', 12, 2)->default(0)->after('total_tva');
            }
        });

        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes')->onDelete('cascade');
            $table->string('designation');
            $table->text('description')->nullable();
            $table->decimal('quantity', 10, 2)->default(1);
            $table->string('unit')->nullable()->default('Unité');
            $table->decimal('unit_price_ht', 12, 2)->default(0);
            $table->decimal('tva_rate', 5, 2)->default(20);
            $table->decimal('total_ht', 12, 2)->default(0);
            $table->decimal('total_tva', 12, 2)->default(0);
            $table->decimal('total_ttc', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_items');

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropColumn([
                'quote_date',
                'seller_id',
                'validity_date',
                'payment_conditions',
                'notes',
                'total_ht',
                'total_tva',
                'total_ttc',
            ]);
        });
    }
};
