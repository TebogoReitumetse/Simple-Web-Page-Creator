<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['page_id', 'type', 'content', 'position'])]
class Section extends Model
{
    public const TYPES = [
        'hero' => 'Hero',
        'two_columns' => 'Two Columns',
        'three_columns' => 'Three Columns',
        'text' => 'Text Block',
        'image' => 'Image',
        'cta' => 'Call to Action',
        'gallery' => 'Gallery',
        'features' => 'Features Grid',
        'testimonial' => 'Testimonial',
        'faq' => 'FAQ',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }
}
