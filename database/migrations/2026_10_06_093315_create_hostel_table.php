<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('hostel', function (Blueprint $table) {
            $table->increments('hostel_id');
            $table->string('hostel_name', 50)->notNull();
            $table->enum('hostel_type', ['Boys', 'Girls'])->notNull();
            $table->unsignedInteger('warden_id')->nullable();
            $table->timestamps();

            $table->foreign('warden_id')
                ->references('warden_id')
                ->on('warden')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('hostel');
    }
};
