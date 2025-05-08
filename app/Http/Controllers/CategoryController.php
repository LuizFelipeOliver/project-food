<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', [
            'categories' => $categories,
            'mode' => 'index',
            'category' => null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', [
            'categories' => $categories,
            'mode' => 'create',
            'category' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        $category = Category::create($validated);

        if ($request->expectsJson()) {
            return response()->json($category);
        }

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', [
            'categories' => $categories,
            'mode' => 'show',
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', [
            'categories' => $categories,
            'mode' => 'edit',
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
        ]);

        $category->update($validated);

        if ($request->expectsJson()) {
            return response()->json($category);
        }

        return redirect()->route('categories.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()->route('categories.index')->with('error', 'Não é possível excluir uma categoria com produtos associados.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoria excluída com sucesso.');
    }
}
