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
        Schema::create('listings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');

            $table->string('title');
            $table->text('description');

            $table->string('city',100);
            $table->string('suburb',100);

            $table->decimal('price',10,2);
            $table->enum('pricing_type',['hourly','fixed']);

            $table->enum('status',['draft','pending','approved','suspended'])
                ->default('draft');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories');

            // 🔥 SCALING INDEXES
            $table->index('user_id');              // provider listings
            $table->index('category_id');          // filter category
            $table->index('city');                 // filter city
            $table->index('status');               // approved filter

            // Composite indexes for common queries
            $table->index(['status','category_id']);
            $table->index(['status','city']);
            $table->index(['status','price']);
            $table->index(['status','created_at']);

            // For sorting by price inside filters
            $table->index(['category_id','price']);

            // Full-text search (MySQL 5.7+)
            $table->fullText(['title','description']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
