<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('enquiry_id');
            $table->unsignedBigInteger('sender_id');

            $table->text('message');
            $table->timestamps();

            $table->foreign('enquiry_id')->references('id')->on('enquiries')->cascadeOnDelete();
            $table->foreign('sender_id')->references('id')->on('users');

            $table->index('enquiry_id');
            $table->index('sender_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
