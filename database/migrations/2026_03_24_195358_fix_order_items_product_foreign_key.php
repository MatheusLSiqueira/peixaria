<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Troca o onDelete('cascade') do product_id em order_items por restrict,
     * evitando que deletar um produto destrua o histórico de pedidos.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Remove a FK antiga (cascade)
            $table->dropForeign(['product_id']);

            // Recria com restrict — impede deletar produto com pedidos vinculados
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }
};
