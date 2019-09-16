<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = config('nova-pages.tables');

        Schema::create($tables['pages'], function (Blueprint $table) use ($tables) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->string('template');
            $table->text('content')->nullable();
            $table->bigInteger('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on($tables['users'])->onDelete('cascade');
            $table->timestamps();
            $table->timestamp('published_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('nova-pages.tables.pages'));
    }
}
