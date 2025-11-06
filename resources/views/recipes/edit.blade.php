@extends('layouts.app')

@section('title', 'Edit Resep - ResepKu')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0"><i class="fas fa-edit"></i> Edit Resep</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('recipes.update', $recipe->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ (old('category_id', $recipe->category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Resep *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $recipe->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Singkat *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" required>{{ old('description', $recipe->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bahan-bahan -->
                        <div class="mb-3">
                            <label for="ingredients" class="form-label">Bahan-Bahan *</label>
                            <textarea class="form-control @error('ingredients') is-invalid @enderror" 
                                      id="ingredients" name="ingredients" rows="8" required>{{ old('ingredients', $recipe->ingredients) }}</textarea>
                            @error('ingredients')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cara Membuat -->
                        <div class="mb-3">
                            <label for="instructions" class="form-label">Cara Membuat *</label>
                            <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                      id="instructions" name="instructions" rows="10" required>{{ old('instructions', $recipe->instructions) }}</textarea>
                            @error('instructions')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Waktu Masak -->
                            <div class="col-md-6 mb-3">
                                <label for="cooking_time" class="form-label">Waktu Masak (menit) *</label>
                                <input type="number" class="form-control @error('cooking_time') is-invalid @enderror" 
                                       id="cooking_time" name="cooking_time" 
                                       value="{{ old('cooking_time', $recipe->cooking_time) }}" min="1" required>
                                @error('cooking_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Porsi -->
                            <div class="col-md-6 mb-3">
                                <label for="servings" class="form-label">Porsi (orang) *</label>
                                <input type="number" class="form-control @error('servings') is-invalid @enderror" 
                                       id="servings" name="servings" 
                                       value="{{ old('servings', $recipe->servings) }}" min="1" required>
                                @error('servings')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Gambar -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Resep</label>
                            
                            @if($recipe->image)
                            <div class="mb-2">
                                <img src="{{ asset($recipe->image) }}" class="img-thumbnail" style="max-height: 200px;">
                                <p class="text-muted small">Gambar saat ini</p>
                            </div>
                            @endif
                            
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, max 2MB</small>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Preview Image -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="preview" src="" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update Resep
                            </button>
                            <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Preview gambar sebelum upload
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection