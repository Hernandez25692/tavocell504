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
        Schema::table('cierres_diarios', function (Blueprint $table) {
            $table->decimal('total_salidas', 10, 2)->default(0)->after('total_abonos');
        });
    }

    public function down(): void
    {
        Schema::table('cierres_diarios', function (Blueprint $table) {
            $table->dropColumn('total_salidas');
        });
    }
};
