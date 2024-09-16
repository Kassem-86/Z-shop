<x-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Your Wishlist</h1>

        @if ($wishlistItems->isEmpty())
            <p>Your wishlist is empty.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($wishlistItems as $wishlistItem)
                    <div class="bg-white p-4 shadow-md rounded-md">
                        <img src="{{ asset('storage/' . $wishlistItem->item->image) }}" alt="{{ $wishlistItem->item->name }}" class="w-full h-64 object-cover mb-4">
                        <h2 class="text-xl font-bold mb-2">{{ $wishlistItem->item->name }}</h2>
                        <p class="text-gray-700 mb-2">Price: ${{ number_format($wishlistItem->item->price, 2) }}</p>
                        
                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add', $wishlistItem->item->id) }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="quantity" class="block text-lg font-medium text-gray-700 mb-2">Quantity:</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $wishlistItem->item->quantity }}" class="w-20 p-2 border rounded-md">
                            </div>
        
                            <!-- Add to Cart Button -->
                            <button type="submit" class="w-full bg-yellow-500 text-white py-3 rounded-md hover:bg-yellow-600 mb-4">
                                Add to Cart
                            </button>
                        </form>
                        
                        <!-- Option to remove from wishlist -->
                        <form action="{{ route('wishlist.remove', $wishlistItem->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Remove from Wishlist</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>
