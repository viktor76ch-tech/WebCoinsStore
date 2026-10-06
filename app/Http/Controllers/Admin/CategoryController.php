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
        $categories = Category::with('parent')
            ->withCount('coins')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->get();

        $tree = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.index', compact('tree'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->makeSlug($data['slug'] ?? $data['name']);

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория создана.');
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->makeSlug($data['slug'] ?? $data['name'], $category->id);

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория обновлена.');
    }

    public function destroy(Category $category)
    {
        if ($category->children()->exists()) {
            return back()->with('error',
                'Нельзя удалить категорию, у которой есть подкатегории. Сначала удалите или перенесите их.');
        }

        if ($category->coins()->exists()) {
            $count = $category->coins()->count();
            return back()->with('error',
                "В категории $count монет. Сначала переназначьте их в другую категорию.");
        }

        $category->delete();

        return back()->with('success', 'Категория удалена.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }

    protected function makeSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value);
        if ($base === '') {
            $base = 'category-' . time();
        }

        $slug = $base;
        $i = 1;
        while (
        Category::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
