<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('generic_name')->nullable();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('dosage')->nullable();
            $table->string('form')->nullable(); // tablet, syrup, capsule, injection, etc.
            $table->string('strength')->nullable();
            $table->string('package_size')->nullable();
            $table->boolean('prescription_required')->default(false);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('sub_category')->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->json('cloudinary_public_ids')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('mrp', 10, 2);
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->date('expiry_date')->nullable();
            $table->text('storage_instructions')->nullable();
            $table->string('slug')->unique();
            $table->enum('status', ['active', 'draft', 'discontinued'])->default('active');
            $table->integer('minimum_stock')->default(0);
            $table->integer('maximum_stock')->default(0);
            $table->text('side_effects')->nullable();
            $table->text('usage_instructions')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->foreignId('generic_id')->nullable()->constrained('generics')->onDelete('set null');
            $table->index(['status', 'prescription_required']);
            $table->index(['category_id', 'status']);
            $table->index(['supplier_id', 'status']);
            $table->index(['stock_quantity', 'minimum_stock']);
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
