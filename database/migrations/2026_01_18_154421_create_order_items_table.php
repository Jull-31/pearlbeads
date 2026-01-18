// ... create_order_items_table.php
public function up()
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained();
        $table->integer('quantity');
        $table->decimal('price', 12, 2); // Harga saat beli (takutnya harga produk berubah nanti)
        $table->timestamps();
    });
}