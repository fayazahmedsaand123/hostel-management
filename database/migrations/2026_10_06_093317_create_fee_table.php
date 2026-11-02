<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('fee', function (Blueprint $table) {
            $table->increments('fee_id');
            $table->unsignedInteger('student_id')->notNull();
            $table->decimal('amount', 8, 2)->notNull();
            $table->date('pay_date')->notNull();
            $table->string('month_for', 15)->notNull();
            $table->enum('payment_mode', ['Cash', 'Online', 'Bank Transfer'])->default('Cash');
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
    public function down(): void
    {
        Schema::dropIfExists('fee');
    }
};
