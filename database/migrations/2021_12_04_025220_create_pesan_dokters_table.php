<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanDoktersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesan_dokters', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('hari');
            $table->string('jam');
            $table->string('jenis');
            $table->string('uid');
            $table->integer('antri');
            $table->string('keluhan');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesan_dokters');
    }
}
