@php $c = $section->content ?? []; @endphp
@switch($section->type)
    @case('hero')
        <div class="row g-2 mb-2">
            <div class="col-md-6"><label class="form-label small">Heading</label><input name="content[heading]" class="form-control form-control-sm" value="{{ $c['heading'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">Subheading</label><input name="content[subheading]" class="form-control form-control-sm" value="{{ $c['subheading'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">CTA label</label><input name="content[cta_label]" class="form-control form-control-sm" value="{{ $c['cta_label'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">CTA URL</label><input name="content[cta_url]" class="form-control form-control-sm" value="{{ $c['cta_url'] ?? '' }}"></div>
        </div>
        @break

    @case('two_columns')
        <div class="row g-2 mb-2">
            <div class="col-md-6"><label class="form-label small">Col 1 heading</label><input name="content[col1_heading]" class="form-control form-control-sm" value="{{ $c['col1_heading'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">Col 2 heading</label><input name="content[col2_heading]" class="form-control form-control-sm" value="{{ $c['col2_heading'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">Col 1 text</label><textarea name="content[col1_text]" class="form-control form-control-sm" rows="3">{{ $c['col1_text'] ?? '' }}</textarea></div>
            <div class="col-md-6"><label class="form-label small">Col 2 text</label><textarea name="content[col2_text]" class="form-control form-control-sm" rows="3">{{ $c['col2_text'] ?? '' }}</textarea></div>
        </div>
        @break

    @case('three_columns')
        <div class="row g-2 mb-2">
            @for($i = 1; $i <= 3; $i++)
                <div class="col-md-4"><label class="form-label small">Col {{ $i }} heading</label><input name="content[col{{$i}}_heading]" class="form-control form-control-sm" value="{{ $c["col{$i}_heading"] ?? '' }}"></div>
            @endfor
            @for($i = 1; $i <= 3; $i++)
                <div class="col-md-4"><label class="form-label small">Col {{ $i }} text</label><textarea name="content[col{{$i}}_text]" class="form-control form-control-sm" rows="3">{{ $c["col{$i}_text"] ?? '' }}</textarea></div>
            @endfor
        </div>
        @break

    @case('text')
        <div class="mb-2"><label class="form-label small">Heading (optional)</label><input name="content[heading]" class="form-control form-control-sm" value="{{ $c['heading'] ?? '' }}"></div>
        <div class="mb-2"><label class="form-label small">Body</label><textarea name="content[body]" class="form-control form-control-sm" rows="5">{{ $c['body'] ?? '' }}</textarea></div>
        @break

    @case('image')
        <div class="row g-2 mb-2">
            <div class="col-md-8"><label class="form-label small">Image URL</label><input name="content[image_url]" class="form-control form-control-sm" value="{{ $c['image_url'] ?? '' }}"></div>
            <div class="col-md-4"><label class="form-label small">Alt text</label><input name="content[alt]" class="form-control form-control-sm" value="{{ $c['alt'] ?? '' }}"></div>
            <div class="col-12"><label class="form-label small">Caption</label><input name="content[caption]" class="form-control form-control-sm" value="{{ $c['caption'] ?? '' }}"></div>
        </div>
        @break

    @case('cta')
        <div class="row g-2 mb-2">
            <div class="col-md-6"><label class="form-label small">Heading</label><input name="content[heading]" class="form-control form-control-sm" value="{{ $c['heading'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">Subheading</label><input name="content[subheading]" class="form-control form-control-sm" value="{{ $c['subheading'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">CTA label</label><input name="content[cta_label]" class="form-control form-control-sm" value="{{ $c['cta_label'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">CTA URL</label><input name="content[cta_url]" class="form-control form-control-sm" value="{{ $c['cta_url'] ?? '' }}"></div>
        </div>
        @break

    @case('gallery')
        <div class="mb-2"><label class="form-label small">Heading</label><input name="content[heading]" class="form-control form-control-sm" value="{{ $c['heading'] ?? '' }}"></div>
        <p class="small text-muted mb-2">Gallery renders 6 grey placeholders. Wire up to media library later.</p>
        @break

    @case('features')
        <div class="row g-2 mb-2">
            <div class="col-md-6"><label class="form-label small">Heading</label><input name="content[heading]" class="form-control form-control-sm" value="{{ $c['heading'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">Subheading</label><input name="content[subheading]" class="form-control form-control-sm" value="{{ $c['subheading'] ?? '' }}"></div>
            @for($i = 1; $i <= 4; $i++)
                <div class="col-md-6"><label class="form-label small">Feature {{ $i }} title</label><input name="content[feature{{$i}}_title]" class="form-control form-control-sm" value="{{ $c["feature{$i}_title"] ?? '' }}"></div>
                <div class="col-md-6"><label class="form-label small">Feature {{ $i }} text</label><input name="content[feature{{$i}}_text]" class="form-control form-control-sm" value="{{ $c["feature{$i}_text"] ?? '' }}"></div>
            @endfor
        </div>
        @break

    @case('testimonial')
        <div class="mb-2"><label class="form-label small">Quote</label><textarea name="content[quote]" class="form-control form-control-sm" rows="3">{{ $c['quote'] ?? '' }}</textarea></div>
        <div class="row g-2 mb-2">
            <div class="col-md-6"><label class="form-label small">Author</label><input name="content[author]" class="form-control form-control-sm" value="{{ $c['author'] ?? '' }}"></div>
            <div class="col-md-6"><label class="form-label small">Role</label><input name="content[role]" class="form-control form-control-sm" value="{{ $c['role'] ?? '' }}"></div>
        </div>
        @break

    @case('faq')
        <div class="mb-2"><label class="form-label small">Heading</label><input name="content[heading]" class="form-control form-control-sm" value="{{ $c['heading'] ?? '' }}"></div>
        @for($i = 1; $i <= 3; $i++)
            <div class="row g-2 mb-2">
                <div class="col-md-5"><label class="form-label small">Q{{ $i }}</label><input name="content[q{{$i}}]" class="form-control form-control-sm" value="{{ $c["q$i"] ?? '' }}"></div>
                <div class="col-md-7"><label class="form-label small">A{{ $i }}</label><input name="content[a{{$i}}]" class="form-control form-control-sm" value="{{ $c["a$i"] ?? '' }}"></div>
            </div>
        @endfor
        @break

    @default
        <p class="small text-muted">No fields defined for this section type.</p>
@endswitch
