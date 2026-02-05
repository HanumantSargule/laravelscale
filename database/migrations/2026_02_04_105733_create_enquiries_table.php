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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('listing_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('provider_id');

            $table->enum('status',['open','closed'])
                ->default('open');

            $table->timestamps();

            $table->foreign('listing_id')->references('id')->on('listings')->cascadeOnDelete();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('provider_id')->references('id')->on('users');

            // Indexes for dashboard queries
            $table->index('listing_id');
            $table->index('customer_id');
            $table->index('provider_id');
            $table->index(['provider_id','status']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
