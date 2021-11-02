<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Supplier;

class HomePageController extends Controller
{
    public function index()
    {
        $product = new Product;
        $product = $product->readAllProduct();
        $categories = Category::all();
        return view('index', compact('product', 'categories'));
    }

    public function readAllProduct()
    {
        $product = new Product;
        return $product->readAllProduct();

    }

    public function searchProduct()
    {
        $product = new Product;
        return $product->seachProduct();
    }

    public function readProductByCategory($category_id)
    {
        $product = new Product;
        return $product->readProductByCategory($category_id);
    }
}

