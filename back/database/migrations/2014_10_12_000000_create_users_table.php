<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('userName')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            // ->default('https://pngtree.com/freepng/black-default-avatar_5944719.html');
            $table->string('cover')->nullable();
            // ->default('https://www.google.com/url?sa=i&url=https%3A%2F%2Fcodepen.io%2Ftag%2Fyoutube%2520progress%2520bar&psig=AOvVaw3suQuXh7hG8QrlLvkX6bTG&ust=1616842790255000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCOiukPzmze8CFQAAAAAdAAAAABAD');
            $table->string('channelDescription')->nullable();
            // $table->Boolean('isAdmin')->nullable();


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
