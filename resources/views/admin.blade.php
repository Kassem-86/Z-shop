{{-- <x-admin-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Layout</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 p-4">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-4">
                <!-- Add Item Button -->
                <a href="create" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Add Item
                </a>
    
            </div>
            <div class="grid grid-cols-4 gap-8">
                @for ($i = 0; $i < 16; $i++)
                    <div class="bg-gray-200 h-40 flex items-center justify-center border border-gray-300 relative">
                        <!-- Square {{ $i + 1 }} -->
                        <!-- Delete Button for Each Item -->
                        <form action="{{ route('items.destroy', $i) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </div>
                @endfor
            </div>
        </div>
    </body>
    </html>
</x-admin-layout> --}}
