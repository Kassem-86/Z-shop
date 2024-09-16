<x-<!DOCTYPE html>
    <html class="h-full bg-gray-100">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="h-full">
        <div class="min-h-full flex flex-col">
            <!-- Horizontal Navbar -->
            <nav class="{{ $navClass ?? 'bg-black' }} w-full">
                <div class="flex items-center justify-between py-4 px-6">
                 <a href="/admin/dashboard">   <div class="text-4xl font-extrabold text-white" style="position: relative;left: 70px">
                        Z-shop
                    </div> </a>
                    <div class="flex items-center space-x-6 text-white" s >
                        <x-nav-link href="/admin/dashboard" :active="request()->is('admin')"  style="font: bolder ; font-size: 200%">Products</x-nav-link>
                    </div>
    
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
    