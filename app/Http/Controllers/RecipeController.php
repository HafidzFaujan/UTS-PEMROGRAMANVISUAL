<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    // Halaman utama
    public function index(Request $request)
    {
        $query = Recipe::with('category')->latest();
        
        // Filter kategori
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Pencarian
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }
        
        $recipes = $query->paginate(12);
        $categories = Category::all();
        
        return view('recipes.index', compact('recipes', 'categories'));
    }
    
    // Detail resep
    public function show($slug)
    {
        $recipe = Recipe::where('slug', $slug)->with('category')->firstOrFail();
        $relatedRecipes = Recipe::where('category_id', $recipe->category_id)
                                ->where('id', '!=', $recipe->id)
                                ->take(3)
                                ->get();
        
        return view('recipes.show', compact('recipe', 'relatedRecipes'));
    }
    
    // Form tambah resep
    public function create()
    {
        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }
    
    // Simpan resep
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'cooking_time' => 'required|integer',
            'servings' => 'required|integer',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        // Upload gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/recipes'), $imageName);
            $data['image'] = 'images/recipes/' . $imageName;
        }
        
        Recipe::create($data);
        
        return redirect()->route('recipes.index')->with('success', 'Resep berhasil ditambahkan!');
    }
    
    // Form edit
    public function edit($slug)
    {
        $recipe = Recipe::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        return view('recipes.edit', compact('recipe', 'categories'));
    }
    
    // Update resep
    public function update(Request $request, $slug)
    {
        $recipe = Recipe::where('slug', $slug)->firstOrFail();
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'cooking_time' => 'required|integer',
            'servings' => 'required|integer',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        // Upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($recipe->image && file_exists(public_path($recipe->image))) {
                unlink(public_path($recipe->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/recipes'), $imageName);
            $data['image'] = 'images/recipes/' . $imageName;
        }
        
        $recipe->update($data);
        
        return redirect()->route('recipes.show', $recipe->slug)->with('success', 'Resep berhasil diupdate!');
    }
    
    // Hapus resep
    public function destroy($slug)
    {
        $recipe = Recipe::where('slug', $slug)->firstOrFail();
        
        // Hapus gambar
        if ($recipe->image && file_exists(public_path($recipe->image))) {
            unlink(public_path($recipe->image));
        }
        
        $recipe->delete();
        
        return redirect()->route('recipes.index')->with('success', 'Resep berhasil dihapus!');
    }
    
    // Like resep
    public function like($slug)
    {
        $recipe = Recipe::where('slug', $slug)->firstOrFail();
        $identifier = request()->ip(); // Pakai IP address
        
        // Cek apakah sudah like
        $existingLike = $recipe->likes()->where('identifier', $identifier)->first();
        
        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $recipe->decrement('likes_count');
            $liked = false;
        } else {
            // Like
            $recipe->likes()->create(['identifier' => $identifier]);
            $recipe->increment('likes_count');
            $liked = true;
        }
        
        return response()->json([
            'liked' => $liked,
            'likes_count' => $recipe->likes_count
        ]);
    }
}