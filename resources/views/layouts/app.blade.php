<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>
                    </div>

                    <!-- User Navigation -->
                    @auth
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" 
                                         alt="{{ Auth::user()->name }}">
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="text-sm text-red-600 hover:text-red-900">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" 
                               class="text-sm text-gray-700 hover:text-gray-900">
                                Log in
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Flash Messages -->
        @if(session('error'))
            <div class="fixed bottom-0 inset-x-0 pb-2 sm:pb-5">
                <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                    <div class="p-2 rounded-lg bg-red-600 shadow-lg sm:p-3">
                        <div class="flex items-center justify-between flex-wrap">
                            <div class="w-0 flex-1 flex items-center">
                                <p class="ml-3 font-medium text-white truncate">
                                    <span class="md:inline">{{ session('error') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
</html> 