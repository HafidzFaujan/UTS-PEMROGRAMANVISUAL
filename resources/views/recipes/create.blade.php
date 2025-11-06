@extends('layouts.app')

@section('title', 'Tambah Resep Baru - ResepKu')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Resep Baru</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Contoh: Nasi Goreng Spesial" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Singkat *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Ceritakan tentang resep ini..." required>{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bahan-bahan -->
                        <div class="mb-3">
                            <label for="ingredients" class="form-label">Bahan-Bahan *</label>
                            <textarea class="form-control @error('ingredients') is-invalid @enderror" 
                                      id="ingredients" name="ingredients" rows="8" 
                                      placeholder="Tuliskan bahan-bahan (satu bahan per baris)&#10;Contoh:&#10;- 2 piring nasi putih&#10;- 2 butir telur&#10;- 3 siung bawang putih" required>{{ old('ingredients') }}</textarea>
                            @error('ingredients')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cara Membuat -->
                        <div class="mb-3">
                            <label for="instructions" class="form-label">Cara Membuat *</label>
                            <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                      id="instructions" name="instructions" rows="10" 
                                      placeholder="Tuliskan langkah-langkah memasak (satu langkah per baris)&#10;Contoh:&#10;1. Panaskan minyak di wajan&#10;2. Tumis bawang putih hingga harum&#10;3. Masukkan telur, orak-arik" required>{{ old('instructions') }}</textarea>
                            @error('instructions')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Waktu Masak -->
                            <div class="col-md-6 mb-3">
                                <label for="cooking_time" class="form-label">Waktu Masak (menit) *</label>
                                <input type="number" class="form-control @error('cooking_time') is-invalid @enderror" 
                                       id="cooking_time" name="cooking_time" value="{{ old('cooking_time') }}" 
                                       placeholder="30" min="1" required>
                                @error('cooking_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Porsi -->
                            <div class="col-md-6 mb-3">
                                <label for="servings" class="form-label">Porsi (orang) *</label>
                                <input type="number" class="form-control @error('servings') is-invalid @enderror" 
                                       id="servings" name="servings" value="{{ old('servings') }}" 
                                       placeholder="4" min="1" required>
                                @error('servings')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Gambar -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Resep</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, max 2MB</small>
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
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Resep
                            </button>
                            <a href="{{ route('recipes.index') }}" class="btn btn-secondary">
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