@extends('layouts.app')

@section('title', $recipe->title . ' - ResepKu')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Recipe Header -->
            <div class="card mb-4">
                @if($recipe->image)
                <img src="{{ asset($recipe->image) }}" class="card-img-top" alt="{{ $recipe->title }}" style="height: 400px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-primary mb-2">{{ $recipe->category->name }}</span>
                            <h1 class="mb-0">{{ $recipe->title }}</h1>
                        </div>
                        <div class="text-end">
                            <span class="like-btn fs-4" data-slug="{{ $recipe->slug }}" style="cursor: pointer;">
                                <i class="fas fa-heart"></i>
                                <span class="likes-count">{{ $recipe->likes_count }}</span>
                            </span>
                        </div>
                    </div>
                    
                    <p class="lead">{{ $recipe->description }}</p>
                    
                    <div class="row text-center my-4">
                        <div class="col-4">
                            <i class="far fa-clock fa-2x text-primary mb-2"></i>
                            <p class="mb-0"><strong>Waktu Masak</strong></p>
                            <p>{{ $recipe->cooking_time }} menit</p>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-user-friends fa-2x text-primary mb-2"></i>
                            <p class="mb-0"><strong>Porsi</strong></p>
                            <p>{{ $recipe->servings }} orang</p>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-calendar fa-2x text-primary mb-2"></i>
                            <p class="mb-0"><strong>Ditambahkan</strong></p>
                            <p>{{ $recipe->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mb-3">
                        <a href="{{ route('recipes.edit', $recipe->slug) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe->slug) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bahan-bahan -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-list"></i> Bahan-Bahan</h4>
                </div>
                <div class="card-body">
                    {!! nl2br(e($recipe->ingredients)) !!}
                </div>
            </div>

            <!-- Cara Membuat -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-tasks"></i> Cara Membuat</h4>
                </div>
                <div class="card-body">
                    {!! nl2br(e($recipe->instructions)) !!}
                </div>
            </div>

            <!-- Related Recipes -->
            @if($relatedRecipes->count() > 0)
            <div class="mt-5">
                <h3 class="mb-4">Resep Sejenis</h3>
                <div class="row g-3">
                    @foreach($relatedRecipes as $related)
                    <div class="col-md-4">
                        <div class="card h-100">
                            @if($related->image)
                            <img src="{{ asset($related->image) }}" class="card-img-top" alt="{{ $related->title }}" style="height: 150px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">{{ $related->title }}</h6>
                                <a href="{{ route('recipes.show', $related->slug) }}" class="btn btn-sm btn-primary">Lihat</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
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