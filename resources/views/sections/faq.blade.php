<section class="section-block bg-light">
    <div class="container" style="max-width: 800px;">
        <h2 class="text-muted text-center mb-4">{{ $content['heading'] ?? 'Frequently Asked Questions' }}</h2>
        <div class="accordion" id="faqAccordion-{{ $section->id }}">
            @for($i = 1; $i <= 3; $i++)
                @php $q = $content["q$i"] ?? "Sample question $i?"; $a = $content["a$i"] ?? 'Sample answer goes here.'; @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ $i === 1 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $section->id }}-{{ $i }}">
                            {{ $q }}
                        </button>
                    </h2>
                    <div id="faq-{{ $section->id }}-{{ $i }}" class="accordion-collapse collapse {{ $i === 1 ? 'show' : '' }}" data-bs-parent="#faqAccordion-{{ $section->id }}">
                        <div class="accordion-body text-secondary">{{ $a }}</div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
