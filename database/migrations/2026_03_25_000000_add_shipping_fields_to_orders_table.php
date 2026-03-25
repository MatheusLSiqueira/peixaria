<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_city')->nullable()->after('status');
            $table->string('shipping_street')->nullable()->after('shipping_city');
            $table->string('shipping_number')->nullable()->after('shipping_street');
            $table->string('shipping_neighborhood')->nullable()->after('shipping_number');
            $table->string('shipping_reference')->nullable()->after('shipping_neighborhood');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_city',
                'shipping_street',
                'shipping_number',
                'shipping_neighborhood',
                'shipping_reference',
            ]);
        });
    }
};
