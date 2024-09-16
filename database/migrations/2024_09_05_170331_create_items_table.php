<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('name');  // Name of the item
            $table->decimal('price', 8, 2);  // Price of the item (max 999,999.99)
            $table->integer('quantity');  // Quantity of the item
            $table->string('image')->nullable();  // URL of the image (nullable if not provided)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');  // Foreign key for category
            $table->timestamps();  // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
