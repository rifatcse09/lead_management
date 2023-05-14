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
        Schema::create('campaign_internals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('campaign_id')->constrained('campaigns', 'id');
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
        Schema::dropIfExists('campaign_internal_user');
    }
};
