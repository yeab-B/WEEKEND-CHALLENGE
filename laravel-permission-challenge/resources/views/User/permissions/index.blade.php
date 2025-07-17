@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Permissions</h1>
            <a href="{{ route('admin.permission.create') }}"
                class="bg-gray-600 hover:bg-gray-400-700 text-white font-semibold py-2 px-4 rounded">
                Add Permission
            </a>
        </div>
        <div class="result mb-4">
            <!-- Result messages or AJAX results will appear here -->
        </div>
        <!-- Permissions table or list can go here -->
    </div>
@endsection
