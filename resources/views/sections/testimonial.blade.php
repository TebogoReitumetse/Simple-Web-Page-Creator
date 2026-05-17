<section class="section-block">
    <div class="container">
        <div class="placeholder-bg p-5 text-center mx-auto" style="max-width: 800px;">
            <i class="bi bi-quote text-muted" style="font-size:3rem;"></i>
            <p class="lead text-secondary fst-italic">"{{ $content['quote'] ?? 'A glowing testimonial from a happy customer goes here.' }}"</p>
            <div class="mt-3">
                <strong class="text-muted">{{ $content['author'] ?? 'Jane Doe' }}</strong>
                <div class="text-secondary small">{{ $content['role'] ?? 'CEO, Example Co.' }}</div>
            </div>
        </div>
    </div>
</section>
