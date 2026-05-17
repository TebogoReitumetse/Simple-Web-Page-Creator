@php
    $footerColumns = \App\Models\FooterItem::query()
        ->where('is_active', true)
        ->orderBy('column_index')
        ->orderBy('position')
        ->get()
        ->groupBy('column_index');
    $siteName = \App\Models\Setting::get('site_name', 'CMS Site');
    $footerTagline = \App\Models\Setting::get('footer_tagline', 'Built with Laravel CMS Boilerplate.');
@endphp
<footer class="bg-dark text-light mt-5 pt-5 pb-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold">{{ $siteName }}</h5>
                <p class="text-secondary small">{{ $footerTagline }}</p>
            </div>
            @foreach($footerColumns as $colIndex => $items)
                <div class="col-md-2">
                    <h6 class="fw-semibold">{{ $items->first()->column_title ?? "Column $colIndex" }}</h6>
                    <ul class="list-unstyled">
                        @foreach($items as $item)
                            <li class="mb-1">
                                @if($item->url)
                                    <a href="{{ $item->url }}" class="text-secondary text-decoration-none small">{{ $item->label }}</a>
                                @else
                                    <span class="text-secondary small">{{ $item->label }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <hr class="border-secondary mt-4">
        <div class="d-flex justify-content-between small text-secondary">
            <span>&copy; {{ date('Y') }} {{ $siteName }}</span>
            <a href="{{ route('admin.login') }}" class="text-secondary text-decoration-none">Admin</a>
        </div>
    </div>
</footer>
