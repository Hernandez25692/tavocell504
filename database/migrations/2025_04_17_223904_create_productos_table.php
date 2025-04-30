<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('categoria')->nullable(); // opcional si deseas clasificar como "celular"
            $table->string('codigo')->unique();
            $table->text('descripcion')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('precio_compra', 10, 2)->default(0);
            $table->decimal('precio_venta', 10, 2)->default(0);
            $table->string('proveedor')->nullable();
            $table->string('imagen')->nullable();

            // Nuevos campos para celulares
            $table->string('imei')->nullable();
            $table->string('color')->nullable();
            $table->string('ram')->nullable();
            $table->string('almacenamiento')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('sistema_operativo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
