@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($page->profile_picture)
                                <img src="{{ $page->profile_picture }}" alt="{{ $page->name }}" class="h-16 w-16 rounded-full object-cover">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="ml-4">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $page->name }}</h1>
                                <p class="text-sm text-gray-500">{{ $page->category }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="https://facebook.com/{{ $page->username ?? $page->page_id }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="h-5 w-5 mr-2 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                View on Facebook
                            </a>
                            
                            <!-- Page Switcher -->
                            @if($allPages->count() > 0)
                            <div class="relative inline-block text-left">
                                <div>
                                    <button type="button" 
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                                            id="page-switcher"
                                            onclick="document.getElementById('switchMenu').classList.toggle('hidden')">
                                        Switch Page
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="switchMenu" 
                                     class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100">
                                    <div class="py-1">
                                        @foreach($allPages as $otherPage)
                                            <form action="{{ route('pages.switch', $otherPage->username ?? $otherPage->page_id) }}" method="POST" class="block">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                                    {{ $otherPage->name }}
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <!-- Page Stats -->
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-6">
                        <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Likes</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($page->likes ?? 0) }}</dd>
                            </div>
                        </div>
                        <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Followers</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($page->followers ?? 0) }}</dd>
                            </div>
                        </div>
                        <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Posts</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($page->posts_count ?? 0) }}</dd>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="space-y-6">
                        <h2 class="text-lg font-medium text-gray-900">Recent Posts</h2>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <p class="text-gray-500 text-center py-8">
                                Coming soon: Your Facebook page posts will appear here.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-0 inset-x-0 pb-2 sm:pb-5">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="p-2 rounded-lg bg-green-600 shadow-lg sm:p-3">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-0 flex-1 flex items-center">
                        <p class="ml-3 font-medium text-white truncate">
                            <span class="hidden md:inline">{{ session('success') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection 