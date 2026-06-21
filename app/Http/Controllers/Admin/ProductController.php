<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('sort_order')->orderBy('name')->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create', [
            'product' => new Product(['stock' => 0, 'sort_order' => 0]),
            'categories' => Category::ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['image'] = $this->handleImage($request, $data['name']) ?? 'images/logo.png';

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', __('Product created successfully.'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::ordered()->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $product->id);

        if ($image = $this->handleImage($request, $data['name'])) {
            $data['image'] = $image;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', __('Product updated successfully.'));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', __('Product deleted.'));
    }

    /**
     * Validate the product form input.
     */
    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'old_price' => ['nullable', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        unset($validated['image']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_best_selling'] = $request->boolean('is_best_selling');
        $validated['is_top_selling'] = $request->boolean('is_top_selling');

        return $validated;
    }

    /**
     * Store an uploaded image into public/images/products and return its relative path.
     */
    private function handleImage(Request $request, string $name): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');
        $filename = Str::slug($name).'-'.Str::random(6).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('images/products'), $filename);

        return 'images/products/'.$filename;
    }

    /**
     * Build a unique slug from the name, ignoring the given id.
     */
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
