<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('username',25)->unique();
            $table->string('avatar',50)->default('avatar.jpg');
            $table->string('email',50)->unique();
            $table->string('phone',20)->unique();
            $table->string('gender',10);
            $table->string('identification',50)->unique()->nullable();
            $table->integer('house_id')->nullable();
            $table->string('role',20)->default('mkenya'); //admin //police
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password',200);
            $table->string('status',20)->default('active');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
