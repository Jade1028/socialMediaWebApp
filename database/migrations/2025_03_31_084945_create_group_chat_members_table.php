<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupChatMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_chat_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_chat_id')->contrained('group_chats')->onDelete('cascade');  //Foreign key for the group chat
            $table->foreignId('user_id')->constraied('users')->onDelete('cascade');  //Foreign key for the users
            $table->enum('role', ['admin', 'member'])->default('member');  //Role of the user in the group chat
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
        Schema::dropIfExists('group_chat_members');
    }
}
