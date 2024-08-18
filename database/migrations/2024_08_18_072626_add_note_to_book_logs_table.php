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
        Schema::table('book_logs', function (Blueprint $table) {
            $table->date("ended_at")->after("borrowed_at")->nullable(true);
            $table->bigInteger("overdue")->default(0)->nullable(false);
            $table->decimal("overdue_cost", 10, 2)->default(0)->nullable(false);
            $table->text("note")->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_logs', function (Blueprint $table) {
            $table->dropColumn("note");
        });
    }
};
