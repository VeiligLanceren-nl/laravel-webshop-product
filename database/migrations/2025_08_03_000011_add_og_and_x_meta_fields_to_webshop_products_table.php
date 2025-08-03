<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('webshop_products', function (Blueprint $table) {
            // Open Graph fields
            $table->string('og_title')
                ->nullable()
                ->after('meta_description');
            $table->text('og_description')
                ->nullable()
                ->after('og_title');
            $table->string('og_image')
                ->nullable()
                ->after('og_description');

            // X (Twitter) meta fields
            $table->string('x_meta_title')
                ->nullable()
                ->after('og_image');
            $table->text('x_meta_description')
                ->nullable()
                ->after('x_meta_title');
            $table->string('x_meta_image')
                ->nullable()
                ->after('x_meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('webshop_products', function (Blueprint $table) {
            $table->dropColumn([
                'og_title',
                'og_description',
                'og_image',
                'x_meta_title',
                'x_meta_description',
                'x_meta_image',
            ]);
        });
    }
};
