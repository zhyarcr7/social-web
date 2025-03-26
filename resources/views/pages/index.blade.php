@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Facebook Pages
                    </h2>
                </div>
            </div>

            <!-- Pages Grid -->
            @if($pages->count() > 0)
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($pages as $page)
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center">
                                    @if($page->profile_picture)
                                        <img src="{{ $page->profile_picture }}" alt="{{ $page->name }}" class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            {{ $page->name }}
                                        </h3>
                                        <p class="text-sm text-gray-500">{{ $page->category }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 grid grid-cols-2 gap-4">
                                    <a href="https://facebook.com/{{ $page->username ?? $page->page_id }}" 
                                       target="_blank"
                                       class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        View on Facebook
                                    </a>
                                    <a href="{{ route('pages.show', $page->username ?? $page->page_id) }}" 
                                       class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        Manage Page
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No Pages Found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Get started by connecting your Facebook pages.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('auth.facebook') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                <svg class="h-5 w-5 mr-2 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Connect Facebook Pages
                            </a>
                        </div>
                    </div>
                </div>
            @endif
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