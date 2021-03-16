<?php

namespace Eduka\Abstracts;

use Illuminate\Support\ServiceProvider;

abstract class EdukaServiceProvider extends ServiceProvider
{
    /**
     * Loads/reloads the eduka hint namespace. It is used to, by default
     * load the eduka nereus namespace, but in case there is a course
     * loaded, then it will override the eduka namespace and use the
     * course namespace.
     *
     * @return void
     */
    protected function loadEdukaViews(string $namespace)
    {
        view()->getFinder()->replaceNamespace('eduka', $namespace);
    }
}
