<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $casts = [
        'id' => 'integer',
        'display_in_list' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function entries()
    {
        return $this->hasManyThrough(Task::class, User::class);
    }
}
