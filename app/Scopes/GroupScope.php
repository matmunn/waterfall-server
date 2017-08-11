<?php

namespace App\Scopes;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class GroupScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $userGroup = Auth::user()->group_id;
        $builder->where('group_id', $userGroup);
    }
}
