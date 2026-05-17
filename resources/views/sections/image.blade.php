<section class="section-block">
    <div class="container">
        <div class="placeholder-img mx-auto" style="max-width: 900px;">
            @if(!empty($content['image_url']))
                <img src="{{ $content['image_url'] }}" alt="{{ $content['alt'] ?? '' }}" class="img-fluid rounded">
            @else
                <span><i class="bi bi-image" style="font-size:3rem;"></i></span>
            @endif
        </div>
        @if(!empty($content['caption']))
            <p class="text-center text-secondary mt-2 small">{{ $content['caption'] }}</p>
        @endif
    </div>
</section>
