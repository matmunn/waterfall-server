<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $casts = [
        'id' => 'integer'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
    public function accountManager()
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }
}
