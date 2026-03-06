<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'integer', 'min:1'],
            'cpu' => ['required', 'integer', 'min:1'],
            'ram_gb' => ['required', 'integer', 'min:1'],
            'disk_gb' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $suffix = 1;

        while (Product::query()->where('slug', $slug)->exists()) {
            $suffix++;
            $slug = $baseSlug.'-'.$suffix;
        }

        Product::create([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'cpu' => $data['cpu'],
            'ram_gb' => $data['ram_gb'],
            'disk_gb' => $data['disk_gb'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Товар добавлен');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'integer', 'min:1'],
            'cpu' => ['required', 'integer', 'min:1'],
            'ram_gb' => ['required', 'integer', 'min:1'],
            'disk_gb' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $suffix = 1;

        while (Product::query()->where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $suffix++;
            $slug = $baseSlug.'-'.$suffix;
        }

        $product->update([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'cpu' => $data['cpu'],
            'ram_gb' => $data['ram_gb'],
            'disk_gb' => $data['disk_gb'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Товар обновлён');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Товар удалён');
    }
}
