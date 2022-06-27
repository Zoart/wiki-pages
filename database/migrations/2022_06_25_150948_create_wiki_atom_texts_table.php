<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wiki_atom_texts', function (Blueprint $table) {
            $table->longText('article_atom_text');
            $table->increments('wiki_page_id')->nullable();
            $table->foreign('wiki_page_id')
            ->references('id')
            ->on('wiki_pages')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wiki_atom_texts');
    }
};
