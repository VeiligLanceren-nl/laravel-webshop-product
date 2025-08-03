<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webshop_product_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webshop_product_id')
                ->constrained('webshop_products')
                ->cascadeOnDelete();
            $table->string('name'); // e.g. Printing, Photoshoot
            $table->decimal('additional_price', 10, 2)->default(0.00);
            $table->boolean('is_required')->default(false); // optional or required
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webshop_product_options');
    }
};
