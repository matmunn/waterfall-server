<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Group;
use App\Scopes\GroupScope;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public $casts = [
        'id' => 'integer'
    ];

    protected $fillable = [
        'message',
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

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'entry_id');
    }
}
