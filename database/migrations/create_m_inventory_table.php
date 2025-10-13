<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('m_inventory', function (Blueprint $table) {
            $table->string('id_inventory')->primary();
            $table->string('category', 100);
            $table->string('name', 255);
            $table->decimal('qty', 15, 2)->default(0);
            $table->string('unit', 50);
            $table->decimal('hpp', 15, 2)->default(0);
            $table->decimal('automargin', 5, 2)->default(0);
            $table->decimal('minsales', 15, 2)->default(0);
            $table->decimal('pricelist', 15, 2)->default(0);
            $table->string('currency', 3)->default('IDR');
            $table->dateTime('lastpurchase')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('WSPrice', 15, 2)->default(0);
            $table->string('brand', 100)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('category');
            $table->index('name');
            $table->index('is_active');
            $table->index('brand');
        });

        // Insert a dummy inventory item
        DB::table('m_inventory')->insert([
            'id_inventory' => 'INV-' . date('Ymd') . '-001',
            'category' => 'Dummy',
            'name' => 'Dummy Wireless Bluetooth Earbuds',
            'qty' => 50,
            'unit' => 'pcs',
            'hpp' => 150000,
            'automargin' => 30.00,
            'minsales' => 195000,
            'pricelist' => 250000,
            'currency' => 'IDR',
            'lastpurchase' => now(),
            'is_active' => true,
            'WSPrice' => 200000,
            'brand' => 'Dummy',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('m_inventory');
    }
};
