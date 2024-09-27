<!-- resources/views/orders.blade.php -->
<x-layout>
    <div class="container mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Your Orders</h2>
        <ul>
            @foreach($orders as $order)
                <li>Order ID: {{ $order->id }} - Item ID: {{ $order->item_id }} - Created at: {{ $order->created_at }}</li>
            @endforeach
        </ul>
    </div>
</x-layout>
