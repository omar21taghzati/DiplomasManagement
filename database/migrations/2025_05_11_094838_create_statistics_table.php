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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->text('additional_notes')->nullable()->comment('Optional notes regarding the certificate request');
            $table->date('taken_date')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('taking_duration')->unsigned()->nullable();
            $table->enum('type_cerf', ['bac', 'diploma'])->comment('Type of certificate requested');            
             $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('stagiaire_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('certificat_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
