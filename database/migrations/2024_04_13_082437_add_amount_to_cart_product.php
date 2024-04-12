<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->unsignedInteger('amount')->after('product_id');
        });
    }

    public function down(): void
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
};
