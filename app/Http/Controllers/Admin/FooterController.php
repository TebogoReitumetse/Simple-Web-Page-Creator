<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterItem;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        return view('admin.footer.index', [
            'title' => 'Footer',
            'items' => FooterItem::orderBy('column_index')->orderBy('position')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateItem($request);
        $data['position'] = (FooterItem::where('column_index', $data['column_index'])->max('position') ?? -1) + 1;
        FooterItem::create($data);
        return back()->with('status', 'Footer item added.');
    }

    public function update(Request $request, FooterItem $footer)
    {
        $footer->update($this->validateItem($request));
        return back()->with('status', 'Footer item updated.');
    }

    public function destroy(FooterItem $footer)
    {
        $footer->delete();
        return back()->with('status', 'Footer item deleted.');
    }

    private function validateItem(Request $request): array
    {
        return $request->validate([
            'column_title' => ['nullable', 'string', 'max:100'],
            'label' => ['required', 'string', 'max:100'],
            'url' => ['nullable', 'string', 'max:255'],
            'column_index' => ['required', 'integer', 'min:1', 'max:6'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
