@extends('layouts.app', ['title' => $page->title, 'metaDescription' => $page->meta_description])

@section('content')
    @forelse($page->sections as $section)
        @include('sections.' . $section->type, ['section' => $section, 'content' => $section->content ?? []])
    @empty
        <div class="container py-5">
            <div class="placeholder-bg p-5 text-center text-muted">
                <h3 class="mb-2">{{ $page->title }}</h3>
                <p class="mb-0">This page has no sections yet. Add some from the admin dashboard.</p>
            </div>
        </div>
    @endforelse
@endsection
