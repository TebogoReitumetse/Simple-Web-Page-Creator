<section class="section-block">
    <div class="container">
        <div class="placeholder-bg p-5 text-center">
            <h2 class="text-muted mb-2">{{ $content['heading'] ?? 'Ready to get started?' }}</h2>
            <p class="text-secondary mb-3">{{ $content['subheading'] ?? 'Tell visitors what to do next.' }}</p>
            <a href="{{ $content['cta_url'] ?? '#' }}" class="btn btn-secondary btn-lg">{{ $content['cta_label'] ?? 'Get Started' }}</a>
        </div>
    </div>
</section>
