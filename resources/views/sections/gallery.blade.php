<section class="section-block bg-light">
    <div class="container">
        @if(!empty($content['heading']))
            <h2 class="text-muted text-center mb-4">{{ $content['heading'] }}</h2>
        @endif
        <div class="row g-3">
            @for($i = 1; $i <= 6; $i++)
                <div class="col-6 col-md-4">
                    <div class="placeholder-img">
                        <i class="bi bi-image text-muted" style="font-size:2rem;"></i>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
