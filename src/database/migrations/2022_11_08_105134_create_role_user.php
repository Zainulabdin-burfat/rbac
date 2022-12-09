<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            // $table->id();
            // $table->foreignId('user_id')->constrained();
            // $table->foreignId('role_id')->constrained();

            $table->unsignedBigInteger('user_id')->constrained();
            $table->unsignedBigInteger('role_id')->constrained();

            $table->primary(['user_id', 'role_id']);
            $table->index(['user_id', 'role_id']);

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
