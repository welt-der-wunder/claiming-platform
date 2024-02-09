<?php

use App\Models\TokenHolder;
use App\Models\User;
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
        Schema::table('token_holders', function (Blueprint $table) {
            $table->string('status')->default(TokenHolder::HOLDER_STATUS_UNCLAIMED);
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('token_holders', function (Blueprint $table) {
            $table->drop('status');
        });
    }
};
