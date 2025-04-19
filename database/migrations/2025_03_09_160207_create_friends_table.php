<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('user_id1')->constrained('users')->onDelete('cascade');  //Create the foreign key user id
            $table->foreignId('user_id2')->constrained('users')->onDelete('cascade');  //Create the foreign key user id for this user's friend
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');  //Create the status column with the default value of pending
            $table->timestamps();

            // Ensure the same relationship does not repeat in any order
            $table->unique(['user_id1', 'user_id2']);
            $table->unique(['user_id2', 'user_id1']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friends');
    }
}
