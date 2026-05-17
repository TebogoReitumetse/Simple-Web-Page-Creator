<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['column_title', 'label', 'url', 'column_index', 'position', 'is_active'])]
class FooterItem extends Model
{
    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
