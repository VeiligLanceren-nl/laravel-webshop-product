<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('webshop_product_images', function (Blueprint $table) {
            $table->unsignedBigInteger('webshop_product_attribute_value_id')
                ->nullable()
                ->after('webshop_product_id');

            $table->foreign('webshop_product_attribute_value_id', 'fk_image_attr_value')
                ->references('id')
                ->on('webshop_product_attribute_values')
                ->nullOnDelete();
        });
    }
};
