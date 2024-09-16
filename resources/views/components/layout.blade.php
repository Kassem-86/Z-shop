

<!DOCTYPE html>
<html class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('categoryDropdown');
            dropdown.classList.toggle('hidden');
        }
    </script>
</head>
<body class="h-full">
    <div class="min-h-full flex flex-col">
        <!-- Horizontal Navbar -->
        <nav class="{{ $navClass ?? 'bg-blue-500' }} w-full">
            <div class="flex items-center justify-between py-4 px-6">
                <div class="text-4xl font-extrabold text-white" style="position: relative;left: 70px">
                    Z-shop
                </div>
                <div class="flex items-center space-x-6 text-white" style="position: relative;left: 110px">
                    <x-nav-link href="/" :active="request()->is('index')">Home</x-nav-link>
                    <x-nav-link href="/shop" :active="request()->is('items.shop')">Shop</x-nav-link>
                    
                    <!-- Category Dropdown -->
                    <div class="relative">
                        <x-nav-link href="#" :active="request()->is('category')" onclick="toggleDropdown()">Category</x-nav-link>
                        <div id="categoryDropdown" class="absolute hidden mt-2 w-48 bg-white text-gray-700 rounded-md shadow-lg z-10">
                            @foreach ($categories as $category)
                                <a href="{{ route('category.items', $category->id) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4" style="position: relative;left:300px;">
                    <!-- Cart Icon -->
                    <a href="/cart" class="text-white hover:text-gray-400">
                        <!-- Cart SVG -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l1 5h10l1-5h2m-3 8a2 2 0 110-4 2 2 0 010 4zm-6 0a2 2 0 110-4 2 2 0 010 4zm9 2H6m9 2H6"></path>
                        </svg>
                    </a>
                    <!-- Wishlist Icon (Heart Icon) -->
                    <a href="/wishlist" class="text-white hover:text-gray-400">
                        <!-- Heart SVG -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                        </svg>
                    </a>
                </div>
                @guest
                <div class="space-x-4">
                    <x-nav-link href="/login" :active="request()->is('login')">Log In</x-nav-link>
                    <x-nav-link href="/register" :active="request()->is('register')">Register</x-nav-link>
                </div>
                @endguest

                @auth
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="rounded-md px-4 py-2 text-lg font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                        Log Out
                    </button>
                </form>
                @endauth
            </div>
        </nav>

        <div class="flex-1">
            <main>
                <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>

