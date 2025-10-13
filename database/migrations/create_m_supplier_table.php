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
        Schema::dropIfExists('m_supplier');

        Schema::create('m_supplier', function (Blueprint $table) {
            $table->increments('id_supplier')->primary();
            $table->string('name', 150);
            $table->text('address');
            $table->string('city', 50);
            $table->string('country', 50);
            $table->string('zipcode', 6);
            $table->string('telephone', 50);
            $table->string('fax', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('tax_name', 150)->nullable();
            $table->text('tax_address')->nullable();
            $table->string('tax_city', 50)->nullable();
            $table->string('tax_country', 50)->nullable();
            $table->string('tax_zipcode', 6)->nullable();
            $table->string('tax_id', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('pic_1', 100)->nullable();
            $table->string('ext_1', 50)->nullable();
            $table->string('pic_2', 100)->nullable();
            $table->string('ext_2', 50)->nullable();
            $table->string('pic_3', 100)->nullable();
            $table->string('ext_3', 50)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Add indexes for better query performance
            $table->index('name');
            $table->index('city');
            $table->index('is_active');
        });

        // Insert a dummy supplier
        DB::table('m_supplier')->insert([
            'id_supplier'=>1,
            'name' => 'PT. DUMMY SUPPLIER',
            'address' => 'Jl. DUMMY SUPPLIER No. 123',
            'city' => 'DUMMY CITY',
            'country' => 'DUMMY COUNTRY',
            'zipcode' => '12345',
            'telephone' => '+123 123456789',
            'fax' => '+123 987654321',
            'email' => 'info@dummysupplier.com',
            'tax_name' => 'PT. DUMMY SUPPLIER',
            'tax_address' => 'Jl. DUMMY SUPPLIER No. 123',
            'tax_city' => 'DUMMY CITY',
            'tax_country' => 'DUMMY COUNTRY',
            'tax_zipcode' => '12345',
            'tax_id' => '01.123.456.7-123.123',
            'is_active' => true,
            'pic_1' => 'John Doe',
            'ext_1' => '+123 123456789',
            'pic_2' => 'Jane Smith',
            'ext_2' => '+123 987654321',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now()->timezone('+07:00'),
            'updated_at' => now()->timezone('+07:00')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('m_supplier');
    }
};
