{{-- <x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 p-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-4 gap-8">
                @foreach ($items as $item)
                    <div class="bg-white p-4 border rounded-md shadow-md">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-32 object-cover mb-4">
                        @else
                            <div class="w-full h-32 bg-gray-200 flex items-center justify-center mb-4">No Image</div>
                        @endif
                        <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                        <p class="text-gray-500">Price: ${{ number_format($item->price, 2) }}</p>
                        <p class="text-gray-500">Quantity: {{ $item->quantity }}</p>
                        
                        <div class="mt-4 flex justify-end">
                            <!-- View Item Button -->
                            <a href="{{ route('items.show', $item->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-500">
                                View Item
                            </a>
                        </div>
                    </div>
                @endforeach
                {{ $items->links() }}

            </div>
        </div>
        
    </body>
    </html>
</x-layout> --}}
<x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 p-4">
        <div class="container mx-auto">

            <!-- Search Bar -->
            <form action="{{ route('shop') }}" method="GET" class="mb-4">
                <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="Search items..." class="p-2 border border-gray-400 rounded-md w-full">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Search</button>
            </form>

            <div class="grid grid-cols-4 gap-8">
                @foreach ($items as $item)
                    <div class="bg-white p-4 border rounded-md shadow-md">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-32 object-cover mb-4">
                        @else
                            <div class="w-full h-32 bg-gray-200 flex items-center justify-center mb-4">No Image</div>
                        @endif
                        <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                        <p class="text-gray-500">Price: ${{ number_format($item->price, 2) }}</p>
                        <p class="text-gray-500">Quantity: {{ $item->quantity }}</p>
                        
                        <div class="mt-4 flex justify-end">
                            <!-- View Item Button -->
                            <a href="{{ route('items.show', $item->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-500">
                                View Item
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $items->appends(['search' => request()->input('search')])->links() }}
            </div>
        </div>
        
    </body>
    </html>
</x-layout>

