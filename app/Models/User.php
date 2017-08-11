<?php

namespace App\Models;

use App\Models\AuthUser;
use App\Scopes\GroupScope;

class User extends AuthUser
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new GroupScope);
    }
}
