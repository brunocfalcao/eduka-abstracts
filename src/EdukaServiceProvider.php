<?php

namespace Eduka\Abstracts;

use Eduka\Analytics\Middleware\GoalsTracing;
use Eduka\Analytics\Middleware\IpTracing;
use Eduka\Analytics\Middleware\VisitTracing;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

abstract class EdukaServiceProvider extends ServiceProvider
{
    protected function customViewNamespace(string $namespace, string $alias)
    {
        view()->getFinder()->replaceNamespace($alias, $namespace);
    }

    protected function extraRoutes(string $path)
    {
        Route::middleware(['web',
               IpTracing::class,
               VisitTracing::class,
               GoalsTracing::class, ])
             ->group(function () use ($path) {
                 include $path;
             });
    }
}
