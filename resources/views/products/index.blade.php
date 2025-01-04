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
                    <div class="flex justify-between mb-4">
                        <a href="{{ route('products.create') }}" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">
                            Add Product
                        </a>
                        <a href="{{ route('products.export-csv') }}" class="btn btn-secondary bg-green-500 text-white px-4 py-2 rounded">
                            Download CSV
                        </a>
                    </div>

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
                            @foreach ($products as $product)
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
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
