@php $page = $page ?? null; @endphp
<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" id="page-title" class="form-control" value="{{ old('title', $page->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Slug <span class="text-muted small">(optional — auto-generated from title)</span></label>
    <input type="text" name="slug" id="page-slug" class="form-control" value="{{ old('slug', $page->slug ?? '') }}">
</div>

@push('scripts')
<script>
(function () {
    var title = document.getElementById('page-title');
    var slug = document.getElementById('page-slug');
    if (!title || !slug) return;

    function slugify(v) {
        return v.toString().toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s_]+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    // Only auto-fill while the user hasn't manually edited the slug.
    var locked = slug.value.trim() !== '';
    slug.addEventListener('input', function () { locked = slug.value.trim() !== ''; });
    title.addEventListener('input', function () {
        if (!locked) slug.value = slugify(title.value);
    });
})();
</script>
@endpush
<div class="mb-3">
    <label class="form-label">Meta description</label>
    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
</div>
<div class="mb-3 form-check">
    <input type="checkbox" name="is_published" value="1" id="is_published" class="form-check-input" {{ old('is_published', $page->is_published ?? true) ? 'checked' : '' }}>
    <label for="is_published" class="form-check-label">Published</label>
</div>
<div class="mb-3 form-check">
    <input type="checkbox" name="is_home" value="1" id="is_home" class="form-check-input" {{ old('is_home', $page->is_home ?? false) ? 'checked' : '' }}>
    <label for="is_home" class="form-check-label">Set as home page</label>
</div>
