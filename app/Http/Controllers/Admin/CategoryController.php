<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $categories = Category::query()
            ->with('parent')
            ->withCount('subcategories')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories.index', compact(
            'categories',
            'search'
        ));
    }

    public function create(): View
    {
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.categories.create', compact(
            'parentCategories'
        ));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        $category->load([
            'parent',
            'subcategories' => fn ($query) => $query->orderBy('name'),
        ]);

        return view('admin.categories.show', compact(
            'category'
        ));
    }

    public function edit(Category $category): View
    {
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->whereKeyNot($category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact(
            'category',
            'parentCategories'
        ));
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): RedirectResponse {
        $category->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->subcategories()->exists()) {
            return back()->with(
                'error',
                'This category cannot be deleted because it has subcategories.'
            );
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}