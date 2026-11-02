<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('allocation', function (Blueprint $table) {
            $table->increments('allocation_id');
            $table->unsignedInteger('student_id')->notNull();
            $table->unsignedInteger('room_id')->notNull();
            $table->date('allot_date')->notNull();
            $table->date('leave_date')->nullable();
            $table->enum('status', ['Active', 'Left'])->default('Active');
            $table->timestamps();

            $table->foreign('student_id')
                ->references('student_id')
                ->on('student')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreign('room_id')
                ->references('room_id')
                ->on('room')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('allocation');
    }
};
