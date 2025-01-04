<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class DashboardController extends Controller
{
    public function dashboard(): View|Factory|Application
    {
        $categoryCount = Category::count();
        $productCount = Product::count();

        return view('dashboard', compact('categoryCount', 'productCount'));
    }
}
