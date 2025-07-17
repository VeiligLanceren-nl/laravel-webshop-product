<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')
                ->nullable()
                ->unique();
            $table->string('name');
            $table->string('slug')
                ->unique()
                ->index();
            $table->text('description')
                ->nullable();
            $table->decimal('price', 10);
            $table->boolean('active')
                ->default(true);
            $table->integer('stock')
                ->default(0);
            $table->decimal('weight')
                ->nullable();
            $table->json('dimensions')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
