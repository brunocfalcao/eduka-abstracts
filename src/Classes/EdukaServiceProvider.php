<?php

namespace Eduka\Abstracts\Classes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EdukaServiceProvider extends ServiceProvider
{
    protected $dir;

    public function boot()
    {
        $this->overrideResources();

        $this->registerCommands();
    }

    /**
     * Overrides all the published resources on the base path. Useful to
     * have a laravel folder structure inside the "overrides" folder and
     * then they will override any file path that is defined inside that
     * folder.
     *
     * @return void
     */
    protected function overrideResources()
    {
        $this->publishes([
            $this->dir.'/../resources/overrides/' => base_path('/'),
        ]);
    }

    protected function customViewNamespace(string $namespace, string $alias)
    {
        view()->getFinder()->replaceNamespace($alias, $namespace);
    }

    protected function extraRoutes(string $path)
    {
        Route::middleware(['web',
            //IpTracing::class,
            //VisitTracing::class,
            //GoalsTracing::class,
        ])
             ->group(function () use ($path) {
                 include $path;
             });
    }

    protected function registerCommands()
    {
    }
}
