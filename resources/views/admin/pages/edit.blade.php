@extends('admin.layout', ['title' => 'Edit Page'])

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-0">{{ $page->title }}</h4>
        <span class="text-muted small">
            <code>/{{ $page->is_home ? '' : $page->slug }}</code>
            @if($page->is_home)<span class="badge bg-info ms-1">Home</span>@endif
            @if($page->is_published)<span class="badge bg-success ms-1">Published</span>@else<span class="badge bg-secondary ms-1">Draft</span>@endif
        </span>
    </div>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> All pages</a>
</div>

<div class="row g-4">
    {{-- LEFT: Section library --}}
    <div class="col-lg-4">
        <div class="card p-3" style="position: sticky; top: 1rem;">
            <h6 class="text-muted mb-1">Section library</h6>
            <p class="small text-muted mb-3">Drag a block onto the page, or click to add it.</p>

            {{-- Hidden form used to add a section by type --}}
            <form method="POST" action="{{ route('admin.pages.sections.store', $page) }}" id="add-section-form" class="d-none">
                @csrf
                <input type="hidden" name="type" id="add-section-type">
            </form>

            <div id="section-library" class="d-flex flex-column gap-2">
                @foreach($sectionTypes as $val => $label)
                    <div class="lib-item d-flex align-items-center gap-2 p-2 border rounded"
                         draggable="true"
                         data-type="{{ $val }}"
                         role="button"
                         tabindex="0"
                         title="Drag onto the page or click to add">
                        <i class="bi bi-grip-vertical text-muted"></i>
                        <span class="flex-grow-1 small fw-semibold">{{ $label }}</span>
                        <i class="bi bi-plus-circle text-muted"></i>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Move Page settings below Section library (left column) --}}
        <div class="card p-4 mt-3" style="position: sticky; top: calc(1rem + 320px);">
            <h6 class="text-muted mb-3">Page settings</h6>
            <form method="POST" action="{{ route('admin.pages.update', $page) }}">
                @csrf @method('PUT')
                @include('admin.pages._form', ['page' => $page])
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ $page->is_home ? url('/') : url($page->slug) }}" target="_blank" class="btn btn-outline-secondary">View page <i class="bi bi-box-arrow-up-right"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- RIGHT: Page settings + sections --}}
    <div class="col-lg-8">
        <h6 class="text-muted mb-2">Sections ({{ $page->sections->count() }})</h6>
        <div id="sections-dropzone">
            @forelse($page->sections as $section)
                <div class="section-card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <button type="button"
                                    class="btn btn-sm btn-link text-decoration-none p-0 me-2 section-toggle"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#section-body-{{ $section->id }}"
                                    aria-expanded="true"
                                    title="Collapse / expand this section">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <span class="badge bg-secondary me-2">#{{ $loop->iteration }}</span>
                            <strong>{{ $section->typeLabel() }}</strong>
                        </div>
                        <div class="d-flex gap-1">
                            <form method="POST" action="{{ route('admin.pages.sections.move', [$page, $section]) }}" class="d-inline">
                                @csrf <input type="hidden" name="direction" value="up">
                                <button class="btn btn-sm btn-outline-secondary" {{ $loop->first ? 'disabled' : '' }}><i class="bi bi-arrow-up"></i></button>
                            </form>
                            <form method="POST" action="{{ route('admin.pages.sections.move', [$page, $section]) }}" class="d-inline">
                                @csrf <input type="hidden" name="direction" value="down">
                                <button class="btn btn-sm btn-outline-secondary" {{ $loop->last ? 'disabled' : '' }}><i class="bi bi-arrow-down"></i></button>
                            </form>
                            <form method="POST" action="{{ route('admin.pages.sections.destroy', [$page, $section]) }}" class="d-inline" onsubmit="return confirm('Delete this section?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="collapse show" id="section-body-{{ $section->id }}">
                    <form method="POST"
                          action="{{ route('admin.pages.sections.update', [$page, $section]) }}"
                          class="section-edit-form"
                          data-preview-url="{{ route('admin.pages.sections.preview', [$page, $section]) }}"
                          data-preview-target="#preview-{{ $section->id }}">
                        @csrf @method('PUT')
                        @include('admin.pages._section_fields', ['section' => $section])
                        <button class="btn btn-sm btn-primary">Save section</button>
                    </form>

                    <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="small text-muted text-uppercase fw-semibold" style="letter-spacing:.04em;">Live preview</span>
                            <span class="preview-status small text-muted"></span>
                        </div>
                        <div class="section-preview" id="preview-{{ $section->id }}">
                            @include('sections.' . $section->type, ['section' => $section, 'content' => $section->content ?? []])
                        </div>
                    </div>
                    </div>{{-- /section-body --}}
                </div>
            @empty
            @endforelse

            <div id="canvas-drop-hint" class="canvas-drop-hint text-center text-muted">
                <i class="bi bi-arrow-down-circle d-block mb-2" style="font-size:1.6rem;"></i>
                Drag a section here, or click one in the library
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    .lib-item { cursor: grab; background:#fff; transition: background .12s, border-color .12s; }
    .lib-item:hover { background:#f4f4f5; border-color:#111 !important; }
    .lib-item.dragging { opacity:.5; }
    #sections-dropzone.drag-over { outline: 2px dashed #111; outline-offset: 4px; border-radius:.5rem; background:#f4f4f5; }

    /* Live preview — frontend section styles are scoped here since the public CSS isn't loaded in admin */
    .section-preview { border:1px solid #e5e7eb; border-radius:.5rem; overflow:hidden; background:#fff; }
    .section-preview .section-block { padding:2.5rem 0; }
    .section-preview .placeholder-bg { background:#e9ecef; border-radius:.5rem; }
    .section-preview .placeholder-img { background:#ced4da; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; color:#6c757d; border-radius:.5rem; }
    .section-preview.is-loading { opacity:.5; }

    /* Collapse toggle ("close design tab") on each section */
    .section-toggle i { transition: transform .15s; }
    .section-toggle.collapsed i { transform: rotate(-90deg); }

    /* Monochrome theme accents */
    .section-toggle, .section-toggle:hover, .section-toggle:focus { color:#111; }

    /* Persistent "drag here" placeholder on the canvas */
    .canvas-drop-hint {
        border: 2px dashed #cbd5e1;
        border-radius: .5rem;
        padding: 2.5rem 1rem;
        color: #94a3b8;
        background: #f8fafc;
        transition: border-color .12s, background .12s, color .12s;
    }
    #sections-dropzone.drag-over .canvas-drop-hint {
        border-color: #111;
        color: #111;
        background: #f4f4f5;
    }
</style>
<script>
(function () {
    var form = document.getElementById('add-section-form');
    var typeInput = document.getElementById('add-section-type');
    var dropzone = document.getElementById('sections-dropzone');
    var library = document.getElementById('section-library');
    if (!form || !dropzone || !library) return;

    function addSection(type) {
        if (!type) return;
        typeInput.value = type;
        form.submit();
    }

    // Click to add (also keyboard: Enter / Space)
    library.querySelectorAll('.lib-item').forEach(function (item) {
        item.addEventListener('click', function () { addSection(item.dataset.type); });
        item.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); addSection(item.dataset.type); }
        });
        item.addEventListener('dragstart', function (e) {
            item.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'copy';
            e.dataTransfer.setData('text/plain', item.dataset.type);
        });
        item.addEventListener('dragend', function () { item.classList.remove('dragging'); });
    });

    // Drop target
    dropzone.addEventListener('dragover', function (e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
        dropzone.classList.add('drag-over');
    });
    dropzone.addEventListener('dragleave', function (e) {
        if (e.target === dropzone) dropzone.classList.remove('drag-over');
    });
    dropzone.addEventListener('drop', function (e) {
        e.preventDefault();
        dropzone.classList.remove('drag-over');
        addSection(e.dataTransfer.getData('text/plain'));
    });
})();

// Live preview: re-render each section as its fields change.
(function () {
    document.querySelectorAll('.section-edit-form').forEach(function (form) {
        var target = document.querySelector(form.dataset.previewTarget);
        if (!target) return;
        var status = form.parentElement.querySelector('.preview-status');
        var token = form.querySelector('input[name="_token"]').value;
        var timer = null;

        function render() {
            var data = new FormData(form);
            data.delete('_method'); // preview endpoint is a plain POST
            target.classList.add('is-loading');
            if (status) status.textContent = 'Updating…';
            fetch(form.dataset.previewUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
                body: data
            })
            .then(function (r) { return r.ok ? r.text() : Promise.reject(r.status); })
            .then(function (html) {
                target.innerHTML = html;
                if (status) status.textContent = 'Preview updated';
            })
            .catch(function () { if (status) status.textContent = 'Preview failed'; })
            .finally(function () { target.classList.remove('is-loading'); });
        }

        form.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(render, 400);
        });
    });
})();

// Remember which sections are collapsed across reloads (add/remove/save reloads the page).
(function () {
    var KEY = 'cms.collapsed.page-{{ $page->id }}';
    function load() { try { return JSON.parse(localStorage.getItem(KEY)) || []; } catch (e) { return []; } }
    function save(ids) { localStorage.setItem(KEY, JSON.stringify(ids)); }

    var bodies = document.querySelectorAll('[id^="section-body-"]');
    var existing = [];
    bodies.forEach(function (el) { existing.push(el.id.replace('section-body-', '')); });

    // Drop stale ids (deleted sections) so storage doesn't grow forever.
    var collapsed = load().filter(function (id) { return existing.indexOf(id) !== -1; });
    save(collapsed);

    // Apply saved state before Bootstrap initializes (no animation on load).
    collapsed.forEach(function (id) {
        var body = document.getElementById('section-body-' + id);
        var btn = document.querySelector('[data-bs-target="#section-body-' + id + '"]');
        if (body) body.classList.remove('show');
        if (btn) { btn.classList.add('collapsed'); btn.setAttribute('aria-expanded', 'false'); }
    });

    bodies.forEach(function (el) {
        var id = el.id.replace('section-body-', '');
        el.addEventListener('hidden.bs.collapse', function () {
            var c = load();
            if (c.indexOf(id) === -1) { c.push(id); save(c); }
        });
        el.addEventListener('shown.bs.collapse', function () {
            save(load().filter(function (x) { return x !== id; }));
        });
    });
})();
</script>
@endpush
@endsection
