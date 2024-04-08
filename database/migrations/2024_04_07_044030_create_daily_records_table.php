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
        Schema::create('daily_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('male_count')->nullable();
            $table->integer('female_count')->nullable();
            $table->float('male_avg_age',8,2)->nullable();
            $table->float('female_avg_age',8,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_records', function (Blueprint $table) {
            //
        });
    }
};
