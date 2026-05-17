<section class="section-block">
    <div class="container">
        <div class="placeholder-bg p-4 mx-auto" style="max-width: 800px;">
            @if(!empty($content['heading']))
                <h2 class="text-muted">{{ $content['heading'] }}</h2>
            @endif
            <div class="text-secondary">{!! nl2br(e($content['body'] ?? 'Text block content. Edit in the admin dashboard to fill this in.')) !!}</div>
        </div>
    </div>
</section>
