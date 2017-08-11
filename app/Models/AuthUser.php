<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Group;
use App\Models\Client;
use App\Models\Category;
use App\Scopes\GroupScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthUser extends Authenticatable
{
    use Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'group_id',
    ];

    public $casts = [
        'id' => 'integer',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'account_manager_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function addTask($task)
    {
        if ($task instanceof Task) {
            $this->tasks()->save($task);
        } else {
            $this->tasks()->create($task);
        }
    }

    public function addTasks($tasks)
    {
        foreach ($tasks as $task) {
            $this->addTask($task);
        }
    }

    public function createToken()
    {
        $this->api_token = sha1(microtime() . str_random(32));
        return $this;
    }
}
