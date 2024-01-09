<?php

use Carbon\Carbon;
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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(Carbon::now());
            $table->string('tag')->nullable();
            $table->decimal('collection')->nullable();
            $table->decimal('percentage')->nullable();
            $table->integer('no_of_attendant')->nullable();
            $table->integer('no_of_members')->nullable();
            $table->boolean('is_executive')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
