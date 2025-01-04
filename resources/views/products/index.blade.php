<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Action Buttons -->
                    <div class="flex justify-between mb-6">
                        <a href="{{ route('products.create') }}" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                            Add Product
                        </a>
                        <a href="{{ route('products.export-csv') }}" class="btn btn-secondary bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600">
                            Download CSV
                        </a>
                    </div>

                    <!-- Search and Filters -->
                    <form method="GET" action="{{ route('products.index') }}" class="mb-6 space-y-4 md:space-y-0 md:flex md:space-x-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search products..." class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label for="price_min" class="block text-sm font-medium text-gray-700">Min Price</label>
                            <input type="number" name="price_min" id="price_min" value="{{ request('price_min') }}" placeholder="Min Price" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="price_max" class="block text-sm font-medium text-gray-700">Max Price</label>
                            <input type="number" name="price_max" id="price_max" value="{{ request('price_max') }}" placeholder="Max Price" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Availability -->
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="availability" id="availability" value="1" {{ request('availability') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <label for="availability" class="text-sm font-medium text-gray-700">In Stock</label>
                        </div>

                        <!-- Search Button -->
                        <div class="flex items-center">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 focus:outline-none">
                                Search
                            </button>
                        </div>
                    </form>

                    <!-- Products Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($products as $product)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $product->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $product->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $product->price }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $product->quantity }}</td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">No products found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
