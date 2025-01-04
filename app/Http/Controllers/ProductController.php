<?php

namespace App\Http\Controllers;

use App\Jobs\ExportProductsToCsv;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request): View|Factory|Application
    {
        $query = Product::query()->with('category');

        if ($request->search !== null) {
            $search = $request->get('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
        }

        if ($request->price_min !== null && $request->price_max !== null) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        if ($request->has('availability')) {
            $query->where('quantity', '>', 0);
        }

        $products = $query->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new products.
     */
    public function create(): View|Factory|Application
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created products in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified products.
     */
    public function edit(Product $product): View|Factory|Application
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified products in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified products from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Export to CSV
     */
    public function exportCsv(): RedirectResponse
    {
        $user = Auth::user(); // Get the authenticated user

        // Dispatch the export job
        ExportProductsToCsv::dispatch($user);

        return redirect()->route('products.index')->with('success', 'Export job has been dispatched. You will receive the CSV file in your email.');
    }
}
