<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageVisit;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $page = Page::query()
            ->where('is_home', true)
            ->where('is_published', true)
            ->with('sections')
            ->first();

        abort_unless($page, 404, 'No home page configured. Create one in the admin dashboard.');

        $this->recordVisit($request, $page);

        return view('page', compact('page'));
    }

    public function show(Request $request, string $slug)
    {
        $page = Page::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->with('sections')
            ->firstOrFail();

        $this->recordVisit($request, $page);

        return view('page', compact('page'));
    }

    private function recordVisit(Request $request, Page $page): void
    {
        PageVisit::create([
            'page_id' => $page->id,
            'slug' => $page->slug,
            'ip' => $request->ip(),
        ]);
    }
}
