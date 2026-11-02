<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('warden', function (Blueprint $table) {
            $table->increments('warden_id');
            $table->string('warden_name', 50)->notNull();
            $table->string('phone', 15)->nullable();
            $table->string('email', 60)->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('warden');
    }
};
