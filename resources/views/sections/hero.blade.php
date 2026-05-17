<section class="section-block bg-light">
    <div class="container">
        <div class="placeholder-bg p-5 text-center">
            <h1 class="display-4 fw-bold text-muted mb-3">{{ $content['heading'] ?? 'Hero Heading' }}</h1>
            <p class="lead text-secondary mb-4">{{ $content['subheading'] ?? 'A short, compelling subheading goes here.' }}</p>
            @if(!empty($content['cta_label']))
                <a href="{{ $content['cta_url'] ?? '#' }}" class="btn btn-secondary btn-lg">{{ $content['cta_label'] }}</a>
            @else
                <button class="btn btn-secondary btn-lg" disabled>Call to Action</button>
            @endif
        </div>
    </div>
</section>
