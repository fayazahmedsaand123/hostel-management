<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('room', function (Blueprint $table) {
            $table->increments('room_id');
            $table->unsignedInteger('hostel_id')->notNull();
            $table->string('room_no', 10)->notNull();
            $table->integer('capacity')->notNull();
            $table->string('room_type', 20)->nullable();
            $table->decimal('rent_per_month', 8, 2)->notNull();
            $table->timestamps();

            $table->unique(['hostel_id', 'room_no']);
            $table->foreign('hostel_id')
                ->references('hostel_id')
                ->on('hostel')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room');
    }
};
