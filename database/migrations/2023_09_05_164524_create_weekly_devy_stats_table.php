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
        Schema::create('weekly_devy_stats', function (Blueprint $table) {
            $table->integer('devy_player_id');
            $table->integer('year');
            $table->integer('week');
            $table->string('opponent');
            $table->string('passing_completion_attempts')->default('0/0');
            $table->integer('passing_yards')->default(0);
            $table->integer('passing_touchdowns')->default(0);
            $table->float('passing_average')->default(0);
            $table->float('passing_qbr')->default(0);
            $table->integer('rushing_carries')->default(0);
            $table->integer('rushing_yards')->default(0);
            $table->integer('rushing_long')->default(0);
            $table->integer('rushing_touchdowns')->default(0);
            $table->float('rushing_average')->default(0);
            $table->integer('receiving_yards')->default(0);
            $table->integer('receiving_catches')->default(0);
            $table->integer('receiving_long')->default(0);
            $table->integer('receiving_touchdowns')->default(0);
            $table->float('receiving_average')->default(0);
            $table->integer('kick_returns_attempts')->default(0);
            $table->integer('kick_returns_yards')->default(0);
            $table->integer('kick_returns_long')->default(0);
            $table->integer('kick_returns_touchdowns')->default(0);
            $table->float('kick_returns_average')->default(0);
            $table->integer('punt_returns_attempts')->default(0);
            $table->integer('punt_returns_yards')->default(0);
            $table->integer('punt_returns_long')->default(0);
            $table->integer('punt_returns_touchdowns')->default(0);
            $table->float('punt_returns_average')->default(0);
            $table->integer('fumbles')->default(0);
            $table->timestamps();
            $table->primary(['devy_player_id', 'week', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_devy_stats');
    }
};
