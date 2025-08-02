<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webshop_product_attribute_value_variant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webshop_product_variant_id')
                ->constrained('webshop_product_variants')
                ->cascadeOnDelete();
            $table->foreignId('webshop_product_attribute_value_id')
                ->constrained('webshop_product_attribute_values')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webshop_product_attribute_value_variant');
    }
};
