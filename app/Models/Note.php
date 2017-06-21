<?php

namespace App\Models;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public $casts = [
        'id' => 'integer'
    ];

    protected $fillable = [
        'message',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'entry_id');
    }
}
