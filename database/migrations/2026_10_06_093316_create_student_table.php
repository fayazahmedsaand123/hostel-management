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
        Schema::create('student', function (Blueprint $table) {
            $table->increments('student_id');
            $table->string('name', 50)->notNull();
            $table->enum('gender', ['M', 'F'])->notNull();
            $table->date('dob')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('department', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->date('join_date')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
