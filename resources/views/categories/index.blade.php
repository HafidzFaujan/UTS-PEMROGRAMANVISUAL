@extends('layouts.app')

@section('title', 'Kelola Kategori - ResepKu')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Form Tambah Kategori -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Kategori Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Nama kategori baru..." required value="{{ old('name') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                        @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>

            <!-- List Kategori -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><i class="fas fa-list"></i> Daftar Kategori</h4>
                </div>
                <div class="card-body">
                    @if($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="50%">Nama Kategori</th>
                                    <th width="25%" class="text-center">Jumlah Resep</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $index => $category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $category->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $category->slug }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $category->recipes_count }} resep</span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('categories.destroy', $category->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini? Semua resep dalam kategori ini juga akan terhapus!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada kategori. Tambahkan kategori pertama Anda!</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-3">
                <a href="{{ route('recipes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection