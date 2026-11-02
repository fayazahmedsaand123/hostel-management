<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('visitor', function (Blueprint $table) {
            $table->increments('visitor_id');
            $table->unsignedInteger('student_id')->notNull();
            $table->string('visitor_name', 50)->notNull();
            $table->string('relation', 20)->nullable();
            $table->date('visit_date')->notNull();
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->timestamps();

            $table->foreign('student_id')
                ->references('student_id')
                ->on('student')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('visitor');
    }
};
