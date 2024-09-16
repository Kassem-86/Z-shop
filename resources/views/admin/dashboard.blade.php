<x-admin-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <style>
            .modal {
                display: none;
            }
            .modal.active {
                display: flex;
            }
        </style>
    </head>
    <body class="bg-gray-100 p-4">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-4">
                <form action="{{ route('items.create') }}" method="GET">
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-black">
                        Add Item
                    </button>
                </form>
                <button id="open-modal" class="bg-black text-white px-4 py-2 rounded-md hover:bg-black">
                    Add Category
                </button>
            </div>

            <!-- Items Table -->
            <div class="bg-white p-4 shadow-md rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->category->name ?? 'No Category' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex space-x-2">
                                    <!-- Edit Button -->
                                    <button data-item="{{ json_encode($item) }}" class="open-edit-modal bg-black text-white px-4 py-2 rounded-md hover:bg-black" style="height:35px ;">
                                        Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        {{ $items->links() }}

                    </tbody>
                </table>
            </div>

            <!-- Edit Item Modal -->
            <div id="edit-modal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-md w-1/3">
                    <h2 class="text-xl font-semibold mb-4">Edit Item</h2>
                    <form id="edit-form" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="edit_name" class="block text-gray-700">Item Name</label>
                            <input type="text" id="edit_name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="edit_category" class="block text-gray-700">Category</label>
                            <select id="edit_category" name="category_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="edit_price" class="block text-gray-700">Price</label>
                            <input type="number" step="0.01" id="edit_price" name="price" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="edit_quantity" class="block text-gray-700">Quantity</label>
                            <input type="number" id="edit_quantity" name="quantity" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" id="close-edit-modal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                Cancel
                            </button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal for Adding Category -->
            <div id="modal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-md w-1/3">
                    <h2 class="text-xl font-semibold mb-4">Add New Category</h2>
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="category_name" class="block text-gray-700">Category Name</label>
                            <input type="text" id="category_name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" id="close-modal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                Cancel
                            </button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- JavaScript for Modal Functionality -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const openModalButton = document.getElementById('open-modal');
                const closeModalButton = document.getElementById('close-modal');
                const modal = document.getElementById('modal');

                openModalButton.addEventListener('click', function() {
                    modal.classList.add('active');
                });

                closeModalButton.addEventListener('click', function() {
                    modal.classList.remove('active');
                });

                window.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        modal.classList.remove('active');
                    }
                });

                const editModal = document.getElementById('edit-modal');
                const closeEditModalButton = document.getElementById('close-edit-modal');
                const openEditModalButtons = document.querySelectorAll('.open-edit-modal');

                openEditModalButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const item = JSON.parse(this.getAttribute('data-item'));
                        document.getElementById('edit_name').value = item.name;
                        document.getElementById('edit_category').value = item.category_id;
                        document.getElementById('edit_price').value = item.price;
                        document.getElementById('edit_quantity').value = item.quantity;
                        document.getElementById('edit-form').action = '/items/' + item.id;

                        editModal.classList.add('active');
                    });
                });

                closeEditModalButton.addEventListener('click', function() {
                    editModal.classList.remove('active');
                });

                window.addEventListener('click', function(event) {
                    if (event.target === editModal) {
                        editModal.classList.remove('active');
                    }
                });
            });
        </script>
    </body>
    </html>
</x-admin-layout>
