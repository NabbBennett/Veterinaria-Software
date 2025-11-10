<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('servicios_realizados', function (Blueprint $table) {
            $table->foreignId('venta_id')->nullable()->after('id')->constrained('ventas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('servicios_realizados', function (Blueprint $table) {
            $table->dropForeign(['venta_id']);
            $table->dropColumn('venta_id');
        });
    }
};