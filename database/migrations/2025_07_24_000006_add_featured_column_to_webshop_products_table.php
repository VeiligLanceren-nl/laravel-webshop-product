<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table('webshop_products', function (Blueprint $table) {
            $table->boolean('featured')
                ->default(false)
                ->after('active');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('webshop_products', function (Blueprint $table) {
            $table->dropColumn('featured');
        });
    }
};
