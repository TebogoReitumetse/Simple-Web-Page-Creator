<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['page_id', 'slug', 'ip'])]
class PageVisit extends Model
{
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
