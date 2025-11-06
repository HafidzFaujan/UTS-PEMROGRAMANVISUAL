<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('recipes')->get();
        return view('categories.index', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories'
        ]);
        
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }
    
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}