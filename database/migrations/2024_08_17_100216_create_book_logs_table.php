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
        Schema::create('book_logs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("book_id")->constrained("books")->cascadeOnDelete();
            $table->foreignUuid("borrower_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreignUuid("librarian_id")->nullable(true)->references("id")->on("users")->nullOnDelete();
            $table->boolean("is_returned")->default(false);
            $table->timestamp("borrowed_at")->nullable();
            $table->timestamp("returned_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_logs');
    }
};
