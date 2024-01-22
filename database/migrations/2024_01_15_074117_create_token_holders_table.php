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
        Schema::create('token_holders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blockno')->nullable();
            $table->timestamp('unix_timestamp')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->string('from')->nullable();
            $table->string('holder_address')->nullable();
            $table->text('block_hash')->nullable();
            $table->string('token_type')->nullable();
            $table->boolean('is_claimed')->default(0);
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
        Schema::dropIfExists('token_holders');
    }
};
