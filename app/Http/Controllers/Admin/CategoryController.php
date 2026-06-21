<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::ordered()->withCount('products')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create', ['category' => new Category(['is_active' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', __('Category created successfully.'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $category->id);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', __('Category updated successfully.'));
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', __('Category deleted.'));
    }

    /**
     * Validate the category form input.
     */
    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'emoji' => ['nullable', 'string', 'max:16'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    /**
     * Build a unique slug from the name, ignoring the given id.
     */
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while (Category::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
