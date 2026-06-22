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

        if ($path = $this->storeImage($request)) {
            $data['image'] = $path;
        }

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

        if ($path = $this->storeImage($request, $category)) {
            $data['image'] = $path;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', __('Category updated successfully.'));
    }

    public function destroy(Category $category)
    {
        if ($category->image && file_exists(public_path($category->image))) {
            @unlink(public_path($category->image));
        }

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
            'name_bn' => ['nullable', 'string', 'max:255'],
            'emoji' => ['nullable', 'string', 'max:16'],
            'image' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        unset($validated['image']); // handled separately as a file upload

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    /**
     * Move an uploaded category image into public/images/categories and return its relative path.
     * Returns null when no file was uploaded. (Stored directly under public/ for shared-hosting friendliness.)
     */
    private function storeImage(Request $request, ?Category $category = null): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');
        $dir = public_path('images/categories');

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Remove the previous image when replacing it.
        if ($category && $category->image && file_exists(public_path($category->image))) {
            @unlink(public_path($category->image));
        }

        $filename = Str::slug($request->input('name')).'-'.time().'.'.$file->getClientOriginalExtension();
        $file->move($dir, $filename);

        return 'images/categories/'.$filename;
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
