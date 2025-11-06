<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('recipes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description');
        $table->text('ingredients');
        $table->text('instructions');
        $table->string('image')->nullable();
        $table->integer('cooking_time'); // dalam menit
        $table->integer('servings');
        $table->integer('likes_count')->default(0);
        $table->timestamps();
    });
}
};
