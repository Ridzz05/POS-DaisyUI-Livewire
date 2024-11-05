<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop table stocks jika exist
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('stok');
        
        // Buat table stok baru
        Schema::create('stok', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('nama_barang', 100);
            $table->string('kode_barang', 20)->unique();
            $table->integer('jumlah')->default(0); // Mengubah 'stok' menjadi 'jumlah'
            $table->decimal('harga_beli', 10, 2)->default(0);
            $table->decimal('harga_jual', 10, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'menipis', 'habis'])->default('tersedia');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key untuk supplier
            $table->foreign('supplier_id')
                  ->references('id')
                  ->on('suppliers')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok');
    }
};