<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Categories Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700">Total Categories</h3>
                        <p class="text-2xl font-bold text-blue-500">{{ $categoryCount }}</p>
                    </div>
                </div>

                <!-- Products Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700">Total Products</h3>
                        <p class="text-2xl font-bold text-green-500">{{ $productCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
