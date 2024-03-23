<?php

namespace Eduka\Abstracts\Classes;

use Brunocfalcao\LaravelHelpers\Traits\ForModels\HasCustomQueryBuilder;
use Illuminate\Database\Eloquent\Model;

abstract class EdukaModel extends Model
{
    use HasCustomQueryBuilder;

    protected $guarded = [];

    public function canBeDeleted()
    {
        return true;
    }
}
