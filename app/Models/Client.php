<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use App\Scopes\GroupScope;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $casts = [
        'id' => 'integer'
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

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
    public function accountManager()
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }
}
