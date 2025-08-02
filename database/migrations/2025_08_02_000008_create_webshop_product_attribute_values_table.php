<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webshop_product_attribute_values', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('webshop_product_attribute_id');

            $table->foreign('webshop_product_attribute_id', 'wpav_attribute_fk')
                ->references('id')
                ->on('webshop_product_attributes')
                ->cascadeOnDelete();

            $table->string('value'); // e.g. Red, XL
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webshop_product_attribute_values');
    }
};
