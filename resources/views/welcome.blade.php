<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuantumAI</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="antialiased bg-gray-100">
    <div class="relative min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">QuantumAI</h1>
                    </div>
                    
                    <div class="flex items-center">
                    @auth
                            <a href="{{ route('dashboard.pages') }}" class="text-gray-700 hover:text-indigo-600 mr-4">Dashboard</a>
                    @else
                            <a href="{{ route('pages.index') }}" class="text-gray-700 hover:text-indigo-600 mr-4">View Pages</a>
                            <a href="{{ route('auth.facebook') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#1877F2] hover:bg-[#166FE5]">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Continue with Facebook
                            </a>
                    @endauth
                    </div>
                </div>
            </div>
                </nav>

        <!-- Hero Section -->
        <main class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="block">Welcome to QuantumAI</span>
                    <span class="block text-indigo-600">Manage Your Facebook Pages</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Connect your Facebook account to manage all your pages in one place. Get insights, post updates, and more.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    @guest
                        <div class="rounded-md shadow">
                            <a href="{{ route('auth.facebook') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-black hover:bg-gray-800 md:py-4 md:text-lg md:px-10">
                                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Continue with Facebook Page
                            </a>
                        </div>
                    @endguest
                </div>
                </div>
            </main>
        </div>
    </body>
</html>
