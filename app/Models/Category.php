<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use App\Scopes\GroupScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $casts = [
        'id' => 'integer',
        'display_in_list' => 'boolean',
    ];

    protected $fillable = [
        'description',
        'display_in_list',
        'hex_color',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'group_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new GroupScope);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
