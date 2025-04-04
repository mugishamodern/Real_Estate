<?php

// create_messages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('set null');
            $table->string('subject')->nullable();
            $table->text('content');
            $table->timestamps();
            
            // Indexing for message queries
            $table->index(['sender_id', 'receiver_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
