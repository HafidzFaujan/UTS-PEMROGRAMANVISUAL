@extends('layouts.app')

@section('title', 'ResepKu - Beranda')

@section('content')
<div class="container py-5">
    <!-- Header & Search -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto text-center">
            <h1 class="display-4 mb-3">
                <i class="fas fa-utensils text-danger"></i> 
                Selamat Datang di ResepKu
            </h1>
            <p class="lead text-muted">Temukan dan bagikan resep masakan favorit Anda</p>
            
            <!-- Search Form -->
            <form action="{{ route('recipes.index') }}" method="GET" class="mt-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control search-box" 
                           placeholder="Cari resep masakan..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Filter Kategori -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-center flex-wrap gap-2">
                <a href="{{ route('recipes.index') }}" 
                   class="badge bg-{{ request('category') ? 'secondary' : 'primary' }} text-decoration-none">
                    Semua
                </a>
                @foreach($categories as $category)
                <a href="{{ route('recipes.index', ['category' => $category->id]) }}" 
                   class="badge bg-{{ request('category') == $category->id ? 'primary' : 'secondary' }} text-decoration-none">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Resep Cards -->
    @if($recipes->count() > 0)
    <div class="row g-4">
        @foreach($recipes as $recipe)
        <div class="col-md-4">
            <div class="card h-100">
                @if($recipe->image)
                <img src="{{ asset($recipe->image) }}" class="card-img-top" alt="{{ $recipe->title }}">
                @else
                <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" alt="No Image">
                @endif
                
                <div class="card-body">
                    <span class="badge bg-primary mb-2">{{ $recipe->category->name }}</span>
                    <h5 class="card-title">{{ $recipe->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($recipe->description, 100) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            <i class="far fa-clock"></i> {{ $recipe->cooking_time }} menit
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-user-friends"></i> {{ $recipe->servings }} porsi
                        </small>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="like-btn" data-slug="{{ $recipe->slug }}">
                            <i class="fas fa-heart"></i>
                            <span class="likes-count">{{ $recipe->likes_count }}</span>
                        </span>
                        <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn btn-sm btn-primary">
                            Lihat Resep <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $recipes->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <h4>Resep tidak ditemukan</h4>
        <p class="text-muted">Coba kata kunci lain atau tambahkan resep baru</p>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Like functionality
    $('.like-btn').click(function() {
        var slug = $(this).data('slug');
        var likeBtn = $(this);
        
        $.ajax({
            url: '/resep/' + slug + '/like',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                likeBtn.find('.likes-count').text(response.likes_count);
                if(response.liked) {
                    likeBtn.addClass('liked');
                } else {
                    likeBtn.removeClass('liked');
                }
            }
        });
    });
});
</script>
@endsection