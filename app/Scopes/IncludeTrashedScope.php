<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IncludeTrashedScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->with(['customer' => function ($query) {
            $query->trashed(); // Include soft-deleted customers automatically
        }]);
    }
}
