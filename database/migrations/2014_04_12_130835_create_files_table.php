<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->unique();
            $table->string('file_url')->unique();
            $table->string('mime');
            $table->string('original_name')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('resized_image_url')->nullable();
            $table->string('cropped_image_url')->nullable();
            $table->integer('file_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
