<section class="section-block bg-light">
    <div class="container">
        <div class="row g-4">
            @for($i = 1; $i <= 3; $i++)
                <div class="col-md-4">
                    <div class="placeholder-bg p-4 h-100">
                        <h4 class="text-muted">{{ $content["col{$i}_heading"] ?? "Column $i" }}</h4>
                        <p class="text-secondary">{{ $content["col{$i}_text"] ?? 'Brief supporting text for this column goes here.' }}</p>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
