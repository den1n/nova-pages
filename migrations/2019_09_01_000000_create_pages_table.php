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
            $table->jsonb('keywords')->nullable()->default('[]');
            $table->string('description')->nullable();
            $table->string('template');
            $table->text('content')->nullable();
            $table->bigInteger('author_id')->unsigned();
            $table->timestamps();
            $table->timestamp('published_at')->useCurrent();

            $table->foreign('author_id')->references('id')->on($tables['users'])->onDelete('cascade');
            $table->index('author_id');
        });

        if (config('database.default') === 'pgsql') {
            DB::statement(sprintf('alter table %s add ts tsvector null', $tables['pages']));
            DB::statement(sprintf('create index %1$s_ts_index on %1$s using gin (ts)', $tables['pages']));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('nova-pages.tables.pages'));
    }
}
