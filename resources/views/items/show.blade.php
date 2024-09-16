<x-layout>
    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-md shadow-md grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column: Image -->
            <div class="flex justify-center">
                @if ($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-auto max-w-md object-cover"> <!-- Adjusted width and height -->
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center">No Image</div>
                @endif
            </div>

            <!-- Right Column: Product Details -->
            <div>
                <h1 class="text-3xl font-bold mb-4">{{ $item->name }}</h1>
                
                <!-- Price Display -->
                <p class="text-2xl text-red-600 font-semibold mb-4">Price: $<span id="itemPrice">{{ number_format($item->price, 2) }}</span></p>

                <!-- Total Price Display -->
                <p class="text-2xl text-black font-semibold mb-4">Total: $<span id="totalPrice">{{ number_format($item->price, 2) }}</span></p>

                <p class="text-gray-700 mb-6">{{ $item->description }}</p>
                <p class="text-gray-700 mb-6">Available Quantity: {{ $item->quantity }}</p> <!-- Display available stock -->

                <!-- Quantity Selector -->
                <form action="{{ route('cart.add', $item->id) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="quantity" class="block text-lg font-medium text-gray-700 mb-2">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $item->quantity }}" class="w-20 p-2 border rounded-md" oninput="updateTotalPrice()">
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="submit" class="w-full bg-yellow-500 text-white py-3 rounded-md hover:bg-yellow-600 mb-4">
                        Add to Cart
                    </button>
                </form>

                <!-- Add to Wishlist Button -->
                <form action="{{ route('wishlist.add', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-md hover:bg-gray-600">
                        Add to Wishlist
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript to update total price dynamically -->
    <script>
        function updateTotalPrice() {
            let price = parseFloat({{ $item->price }});
            let quantity = document.getElementById('quantity').value;
            let totalPrice = price * quantity;

            // Update the total price display
            document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
        }
    </script>
</x-layout>
