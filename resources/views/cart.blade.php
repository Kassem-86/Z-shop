<x-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Your Cart</h1>

        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($cartItems as $cartItem)
                    <div class="bg-white p-4 shadow-md rounded-md">
                        <img src="{{ asset('storage/' . $cartItem->item->image) }}" alt="{{ $cartItem->item->name }}" class="w-full h-64 object-cover mb-4">
                        <h2 class="text-xl font-bold mb-2">{{ $cartItem->item->name }}</h2>
                        <p class="text-gray-700 mb-2">Price: ${{ number_format($cartItem->item->price, 2) }}</p>
                        <p class="text-gray-700 mb-4">Quantity: {{ $cartItem->quantity }}</p>
                        <p class="text-gray-700 mb-4">Total: ${{ number_format($cartItem->item->price * $cartItem->quantity, 2) }}</p>
                        
                        <!-- Option to remove from cart -->
                        <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Remove from Cart</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4">Total Price: ${{ number_format($totalPrice, 2) }}</h2>
                <button class="bg-green-500 text-white py-3 px-6 rounded-md hover:bg-green-600">Proceed to Checkout</button>
            </div>
        @endif
    </div>
</x-layout>
