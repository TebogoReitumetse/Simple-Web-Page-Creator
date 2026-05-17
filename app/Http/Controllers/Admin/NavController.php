<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavItem;
use Illuminate\Http\Request;

class NavController extends Controller
{
    public function index()
    {
        return view('admin.nav.index', [
            'title' => 'Navigation',
            'items' => NavItem::orderBy('position')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateItem($request);
        $data['position'] = (NavItem::max('position') ?? -1) + 1;
        NavItem::create($data);
        return back()->with('status', 'Nav item added.');
    }

    public function update(Request $request, NavItem $nav)
    {
        $nav->update($this->validateItem($request));
        return back()->with('status', 'Nav item updated.');
    }

    public function destroy(NavItem $nav)
    {
        $nav->delete();
        return back()->with('status', 'Nav item deleted.');
    }

    public function move(Request $request, NavItem $nav)
    {
        $siblings = NavItem::orderBy('position')->get();
        $index = $siblings->search(fn($s) => $s->id === $nav->id);
        $direction = $request->input('direction');
        if ($direction === 'up' && $index > 0) $swap = $siblings[$index - 1];
        elseif ($direction === 'down' && $index < $siblings->count() - 1) $swap = $siblings[$index + 1];
        else return back();
        [$a, $b] = [$nav->position, $swap->position];
        $nav->update(['position' => $b]);
        $swap->update(['position' => $a]);
        return back();
    }

    private function validateItem(Request $request): array
    {
        return $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'url' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
