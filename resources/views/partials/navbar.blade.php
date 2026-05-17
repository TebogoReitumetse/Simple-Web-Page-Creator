@php
    $navItems = \App\Models\NavItem::query()->where('is_active', true)->orderBy('position')->get();
    $siteName = \App\Models\Setting::get('site_name', 'CMS Site');
@endphp
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">{{ $siteName }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                @foreach($navItems as $item)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $item->url }}">{{ $item->label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
