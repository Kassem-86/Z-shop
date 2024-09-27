<!-- resources/views/payment/success.blade.php -->

<x-layout>
    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 border rounded-md shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Order Successful!</h2>
            <p class="mb-4">Thank you for your order. Your payment has been processed successfully.</p>
            <a href="{{ route('orders') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">See order</a>
        </div>
    </div>
</x-layout>
