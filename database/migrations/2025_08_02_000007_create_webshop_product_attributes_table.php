<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webshop_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Color, Size
            $table->boolean('is_variation')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webshop_product_attributes');
    }
};
