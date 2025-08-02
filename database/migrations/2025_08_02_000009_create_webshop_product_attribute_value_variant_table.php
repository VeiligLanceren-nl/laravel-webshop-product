<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webshop_product_attribute_value_variant', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('webshop_product_variant_id');
            $table->unsignedBigInteger('webshop_product_attribute_value_id');

            $table->foreign('webshop_product_variant_id', 'wpav_variant_fk')
                ->references('id')
                ->on('webshop_product_variants')
                ->cascadeOnDelete();

            $table->foreign('webshop_product_attribute_value_id', 'wpav_value_fk')
                ->references('id')
                ->on('webshop_product_attribute_values')
                ->cascadeOnDelete();

            $table->unique(
                ['webshop_product_variant_id', 'webshop_product_attribute_value_id'],
                'wpav_variant_value_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webshop_product_attribute_value_variant');
    }
};
