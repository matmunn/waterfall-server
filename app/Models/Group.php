<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
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

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
