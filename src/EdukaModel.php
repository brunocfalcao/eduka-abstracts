<?php

namespace Eduka\Abstracts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class EdukaModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Saves all given items in the respective model.
     * E.g.: $Car->saveAll([ ['brand=> 'mercedes'], ['brand' => 'Nissan']]).
     *
     * Returns the saved models collection.
     *
     * @param  array  $dataItems
     * @return Collection
     */
    public static function saveWith(array $dataItems)
    {
        $createdModels = collect();

        //1 level deep? wrap it.
        if (! is_array(optional($dataItems)[0])) {
            $dataItems = Arr::wrap([$dataItems]);
        }

        collect($dataItems)->each(function ($dataItem) use (&$createdModels) {
            $model = new static;

            collect($dataItem)->each(function ($value, $key) use ($model, &$createdModels) {
                $model->{$key} = $value;
            });

            $model->save();

            $createdModels->push($model);
        });

        return $createdModels->count() == 1 ? $createdModels->first() : $createdModels;
    }
}
