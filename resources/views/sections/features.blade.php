<section class="section-block">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-muted">{{ $content['heading'] ?? 'Features' }}</h2>
            <p class="text-secondary">{{ $content['subheading'] ?? 'What makes this product great.' }}</p>
        </div>
        <div class="row g-4">
            @for($i = 1; $i <= 4; $i++)
                <div class="col-md-6 col-lg-3">
                    <div class="placeholder-bg p-4 h-100 text-center">
                        <i class="bi bi-star-fill text-muted mb-2" style="font-size:2rem;"></i>
                        <h5 class="text-muted">{{ $content["feature{$i}_title"] ?? "Feature $i" }}</h5>
                        <p class="text-secondary small">{{ $content["feature{$i}_text"] ?? 'Concise description of this feature.' }}</p>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
