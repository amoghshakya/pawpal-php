<?php

use App\Models\User;
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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('name');
            $table->string('species');
            $table->string('breed')->nullable();
            $table->string('age')->nullable();
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');
            $table->text('description')->nullable();
            $table->boolean('vaccinated')->default(false);
            $table->text('vaccination_details')->nullable();
            $table->text('special_needs')->nullable();
            $table->string('location');
            $table->enum('status', ['available', 'adopted'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
