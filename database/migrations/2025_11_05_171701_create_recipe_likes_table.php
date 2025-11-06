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
    Schema::create('recipe_likes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
        $table->string('identifier'); // IP address atau session ID
        $table->timestamps();
        
        $table->unique(['recipe_id', 'identifier']);
    });
}
};
