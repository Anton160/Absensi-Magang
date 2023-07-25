<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id');
            $table->string('image')->nullable()->unique();
            $table->double('latitude', 10, 8)->nullable();
            $table->double('longitude', 11, 8)->nullable();
            $table->boolean('present')->default(0);
            $table->boolean('sick')->default(0);
            $table->boolean('permission')->default(0);
            $table->boolean('notAbsent')->default(1);
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->timestamps();
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
