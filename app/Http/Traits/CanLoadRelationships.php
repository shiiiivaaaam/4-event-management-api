<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships{


    public function LoadRelationships(Model| QueryBuilder|EloquentBuilder|HasMany $for , ?array $relations=null){

        $relations  = $relations ?? $this->relations ?? [];

        foreach ($relations as $relation){
            $for->when (
                $this->ShouldIncludeRelation($relation),
                function ($query)use($for,$relation){
                    return (($for instanceof Model)? $for->load($relation) : $query->with($relation)) ;
                }
            );
        }
        return $for;
    }


    protected function ShouldIncludeRelation(string $relation){

    $include = request()->query('include');

    if(!$include){
        return false ;
    }
    $relations  = array_map('trim',explode(',',$include));

    return in_array($relation , $relations);
}
}
