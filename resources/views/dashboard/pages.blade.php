@extends('layouts.app')

@section('content')
<div class="py-10">
    <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Dashboard
            </h1>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 py-8 sm:px-0">
                @if (session('success'))
                    <div class="rounded-md bg-green-50 p-4 mb-8">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
                    <div class="px-4 py-4 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Your Facebook Pages</h3>
                        
                        @if(count($pages) > 0)
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($pages as $page)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center">
                                            @if(isset($page['picture']['data']['url']))
                                                <img src="{{ $page['picture']['data']['url'] }}" 
                                                     alt="{{ $page['name'] }}" 
                                                     class="w-12 h-12 rounded-full">
                                            @endif
                                            <div class="ml-3">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $page['name'] }}</h4>
                                                @if(isset($page['category']))
                                                    <p class="text-xs text-gray-500">{{ $page['category'] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-4 flex justify-end space-x-2">
                                            <a href="https://facebook.com/{{ $page['username'] ?? $page['id'] }}" 
                                               target="_blank"
                                               class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                                View on Facebook
                                            </a>
                                            <a href="{{ route('pages.show', $page['id']) }}" 
                                               class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700">
                                                Manage Page
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-sm text-gray-500 mb-4">No Facebook pages found.</p>
                                <a href="{{ route('auth.facebook') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                    Connect Facebook Pages
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 