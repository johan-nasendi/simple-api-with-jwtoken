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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('author')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->longText('desc')->nullable();
            $table->string('brief_desc')->nullable();
            $table->enum('status',['publish','draft'])->nullable()->default('publish');
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')
            ->onUpdate('cascade');
            $table->foreign('author')->references('id')->on('users')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
