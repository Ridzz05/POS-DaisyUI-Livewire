<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->after('id'); // Sesuaikan posisi kolom
        });
    }
 
    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }
};
