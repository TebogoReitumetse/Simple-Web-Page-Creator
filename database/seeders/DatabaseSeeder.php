<?php

namespace Database\Seeders;

use App\Models\FooterItem;
use App\Models\NavItem;
use App\Models\Page;
use App\Models\Section;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        Setting::set('site_name', 'My CMS Site');
        Setting::set('footer_tagline', 'Built with the Laravel CMS Boilerplate.');

        $home = Page::updateOrCreate(
            ['slug' => 'home'],
            ['title' => 'Home', 'is_home' => true, 'is_published' => true, 'meta_description' => 'Welcome to our site.']
        );
        $home->sections()->delete();

        $sections = [
            ['type' => 'hero', 'content' => ['heading' => 'Welcome to Your New CMS', 'subheading' => 'Build pages with reusable sections like Wix.', 'cta_label' => 'Get Started', 'cta_url' => '/about']],
            ['type' => 'three_columns', 'content' => [
                'col1_heading' => 'Easy to Edit', 'col1_text' => 'Manage pages and sections from a clean admin dashboard.',
                'col2_heading' => 'Section Library', 'col2_text' => 'Hero, columns, CTA, gallery, FAQ and more out of the box.',
                'col3_heading' => 'Extensible', 'col3_text' => 'Built on Laravel — easy to extend with custom section types.',
            ]],
            ['type' => 'two_columns', 'content' => [
                'col1_heading' => 'Manage Navigation', 'col1_text' => 'Add, reorder and toggle nav items from the dashboard.',
                'col2_heading' => 'Manage Footer', 'col2_text' => 'Organize footer links into columns, with titles per column.',
            ]],
            ['type' => 'features', 'content' => [
                'heading' => 'Why this boilerplate?', 'subheading' => 'Everything you need to start a CMS-driven site.',
                'feature1_title' => 'Pages', 'feature1_text' => 'Unlimited pages with slugs and SEO meta.',
                'feature2_title' => 'Sections', 'feature2_text' => '10 ready-made section types.',
                'feature3_title' => 'Users', 'feature3_text' => 'Admin user management built in.',
                'feature4_title' => 'Settings', 'feature4_text' => 'Site-wide settings with caching.',
            ]],
            ['type' => 'testimonial', 'content' => ['quote' => 'This boilerplate saved me weeks of work.', 'author' => 'A Happy Developer', 'role' => 'Indie Hacker']],
            ['type' => 'cta', 'content' => ['heading' => 'Ready to launch?', 'subheading' => 'Customize sections and ship your site today.', 'cta_label' => 'Open Admin', 'cta_url' => '/admin']],
        ];
        foreach ($sections as $i => $s) {
            $home->sections()->create([...$s, 'position' => $i]);
        }

        Page::updateOrCreate(
            ['slug' => 'about'],
            ['title' => 'About', 'is_published' => true, 'meta_description' => 'About this site.']
        )->sections()->delete();
        $about = Page::where('slug', 'about')->first();
        $about->sections()->createMany([
            ['type' => 'hero', 'content' => ['heading' => 'About Us', 'subheading' => 'A short story about who we are.'], 'position' => 0],
            ['type' => 'text', 'content' => ['heading' => 'Our Mission', 'body' => "We build great software.\n\nWe ship boilerplates so others can do the same."], 'position' => 1],
        ]);

        NavItem::query()->delete();
        foreach ([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'About', 'url' => '/about'],
            ['label' => 'Contact', 'url' => '#'],
        ] as $i => $item) {
            NavItem::create([...$item, 'position' => $i, 'is_active' => true]);
        }

        FooterItem::query()->delete();
        $footer = [
            // column 1
            ['column_index' => 1, 'column_title' => 'Product', 'label' => 'Features', 'url' => '#', 'position' => 0],
            ['column_index' => 1, 'column_title' => null, 'label' => 'Pricing', 'url' => '#', 'position' => 1],
            // column 2
            ['column_index' => 2, 'column_title' => 'Company', 'label' => 'About', 'url' => '/about', 'position' => 0],
            ['column_index' => 2, 'column_title' => null, 'label' => 'Contact', 'url' => '#', 'position' => 1],
            // column 3
            ['column_index' => 3, 'column_title' => 'Legal', 'label' => 'Privacy', 'url' => '#', 'position' => 0],
            ['column_index' => 3, 'column_title' => null, 'label' => 'Terms', 'url' => '#', 'position' => 1],
        ];
        foreach ($footer as $f) {
            FooterItem::create([...$f, 'is_active' => true]);
        }
    }
}
