<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        return view('admin.pages.index', [
            'title' => 'Pages',
            'pages' => Page::orderByDesc('is_home')->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.pages.create', ['title' => 'New Page']);
    }

    public function store(Request $request)
    {
        $data = $this->validatePage($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title']);
        if (!empty($data['is_home'])) {
            Page::query()->update(['is_home' => false]);
        }
        $page = Page::create($data);
        return redirect()->route('admin.pages.edit', $page)->with('status', 'Page created.');
    }

    public function edit(Page $page)
    {
        $page->load('sections');
        return view('admin.pages.edit', [
            'title' => "Edit: {$page->title}",
            'page' => $page,
            'sectionTypes' => Section::TYPES,
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validatePage($request, $page->id);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title'], $page->id);
        if (!empty($data['is_home'])) {
            Page::query()->where('id', '!=', $page->id)->update(['is_home' => false]);
        }
        $page->update($data);
        return redirect()->route('admin.pages.edit', $page)->with('status', 'Page updated.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('status', 'Page deleted.');
    }

    public function addSection(Request $request, Page $page)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'in:' . implode(',', array_keys(Section::TYPES))],
        ]);
        $position = ($page->sections()->max('position') ?? -1) + 1;
        $page->sections()->create([
            'type' => $data['type'],
            'content' => [],
            'position' => $position,
        ]);
        return back()->with('status', 'Section added.');
    }

    public function updateSection(Request $request, Page $page, Section $section)
    {
        abort_if($section->page_id !== $page->id, 404);
        $content = $request->input('content', []);
        $section->update(['content' => array_filter($content, fn($v) => $v !== null && $v !== '')]);
        return back()->with('status', 'Section saved.');
    }

    public function previewSection(Request $request, Page $page, Section $section)
    {
        abort_if($section->page_id !== $page->id, 404);
        $view = 'sections.' . $section->type;
        abort_unless(view()->exists($view), 404);
        $content = array_filter(
            (array) $request->input('content', []),
            fn($v) => $v !== null && $v !== ''
        );
        // Not persisted — only used to render the live preview.
        $section->content = $content;
        return view($view, ['section' => $section, 'content' => $content]);
    }

    public function deleteSection(Page $page, Section $section)
    {
        abort_if($section->page_id !== $page->id, 404);
        $section->delete();
        return back()->with('status', 'Section deleted.');
    }

    public function moveSection(Request $request, Page $page, Section $section)
    {
        abort_if($section->page_id !== $page->id, 404);
        $direction = $request->input('direction');
        $siblings = $page->sections()->orderBy('position')->get();
        $index = $siblings->search(fn($s) => $s->id === $section->id);
        if ($direction === 'up' && $index > 0) {
            $swap = $siblings[$index - 1];
        } elseif ($direction === 'down' && $index < $siblings->count() - 1) {
            $swap = $siblings[$index + 1];
        } else {
            return back();
        }
        [$a, $b] = [$section->position, $swap->position];
        $section->update(['position' => $b]);
        $swap->update(['position' => $a]);
        return back();
    }

    private function validatePage(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
            'is_home' => ['nullable', 'boolean'],
        ]) + ['is_published' => $request->boolean('is_published'), 'is_home' => $request->boolean('is_home')];
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: 'page';
        $slug = $base; $i = 1;
        while (Page::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }
}
