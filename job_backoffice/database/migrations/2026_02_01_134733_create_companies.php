<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Polyfill\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->Uuid('id')->primary();
            $table->string('name');
            $table->string('address');
            $table->string('industry');     
            $table->string('website')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Corrected relationship: 
       
            $table->foreignUuid('ownerId')->constrained('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('companies');
    }
};
