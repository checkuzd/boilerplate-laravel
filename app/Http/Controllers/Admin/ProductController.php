<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct() {}

    public function index(): View
    {
        return view('admin.product.index');
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:250',
            'status' => 'boolean',
            'price' => 'required',
            'old_price' => 'sometimes',
            'stock' => 'required',
            'stock_alert' => 'sometimes',
        ]);
        try {
            DB::transaction(function () use ($validatedData, $request) {
                $product = Product::create($validatedData);
                if ($request->hasFile('product_images')) {
                    $product->addAllMediaFromRequest('product_images')->toMediaCollection('product-images');
                }
            });
        } catch (\Throwable $th) {
            return back()
                ->with('error', 'Product cannot be added!')
                ->withInput($request->all());
        }

        return to_route('admin.products.index')->with('success', 'Product added successfully');
    }

    public function edit() {}

    public function update(Request $request) {}

    public function destroy() {}
}
