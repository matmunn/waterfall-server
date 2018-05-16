<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\User;
use App\Models\Client;
use App\Scopes\GroupScope;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";

    protected $fillable = [
        'description',
        'start_date',
        'end_date',
        'completed',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'group_id',
    ];

    public $casts = [
        'completed' => 'boolean',
        'is_recurring' => 'boolean',
        'task_added_during_week' => 'boolean',
        'is_absence' => 'boolean',
        'id' => 'integer',
    ];

    public $timestamps = [
        'start_date',
        'end_date'
    ];

    public $appends = [
        'blocks'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function markCompleted()
    {
        $this->completed = true;
        $this->save();
    }

    public function markIncomplete()
    {
        $this->completed = false;
        $this->save();
    }

    public function toggleCompletion()
    {
        $this->completed = ! $this->completed;
        $this->save();
    }

    public function isCompleted()
    {
        return !! $this->completed;
    }

    public function getBlocks()
    {
        $startDate = new Carbon($this->start_date);
        $startOfWeek = $startDate->copy()->startOfWeek();

        $endDate = new Carbon($this->end_date);

        $taskDurationRange = date_range($startDate, $endDate);

        $blocks = [];

        foreach ($taskDurationRange as $block) {
            if ($block->hour >= 9 && $block->hour < 17 && $block->hour != 13) {
                $startOfDay = $block->copy()->hour(9);
                $blockOffset = ($startOfWeek->diffInDays($block) * 7) + $startOfDay->diffInHours($block);
                
                if ($block->hour >= 14) {
                    $blockOffset -= 1;
                }

                $blocks[] = $blockOffset;
            }
        }

        return $blocks;
    }

    public function getBlocksAttribute()
    {
        return $this->getBlocks();
    }
}
