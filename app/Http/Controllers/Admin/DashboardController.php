<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterItem;
use App\Models\NavItem;
use App\Models\Page;
use App\Models\PageVisit;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $days = 30;
        $start = Carbon::today()->subDays($days - 1);

        $counts = PageVisit::query()
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as total'))
            ->pluck('total', 'day');

        $visitLabels = [];
        $visitData = [];
        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            $visitLabels[] = $date->format('M j');
            $visitData[] = (int) ($counts[$date->toDateString()] ?? 0);
        }

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'stats' => [
                'pages' => Page::count(),
                'sections' => Section::count(),
                'nav_items' => NavItem::count(),
                'footer_items' => FooterItem::count(),
                'users' => User::count(),
            ],
            'recentPages' => Page::latest()->limit(5)->get(),
            'visitLabels' => $visitLabels,
            'visitData' => $visitData,
        ]);
    }
}
