<?php

namespace Eduka\Abstracts\Classes;

use Eduka\Nereus\Facades\Nereus;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class EdukaServiceProvider extends ServiceProvider
{
    protected $dir;

    public function boot()
    {
        $this->overrideResources();

        if (Nereus::matchCourse() || Nereus::matchBackend()) {
            Vite::macro('file', function (string $path) {
                return $this->asset("resources/{$path}");
            });
        }


        // Load anonymous Blade components, if directory exists
        if (is_dir($this->dir.'/../resources/views/components')) {
            Blade::anonymousComponentPath($this->dir.'/../resources/views/components');
        }

        if (Nereus::matchCourse()) {
            Vite::useBuildDirectory('vendor/'.Nereus::course()->canonical);
            $this->customViewNamespace($this->dir.'/../resources/views', 'course');
            $this->loadTranslationsFrom($this->dir.'/../lang', 'course');
        }

        if (Nereus::matchBackend()) {
            Vite::useBuildDirectory('vendor/'.Nereus::backend()->canonical);
            $this->customViewNamespace($this->dir.'/../resources/views', 'backend');
            $this->loadTranslationsFrom($this->dir.'/../lang', 'backend');
        }

        $this->loadMigrationsFrom($this->dir.'/../database/migrations');
    }

    public function register()
    {
        //
    }

    /**
     * Overrides all the published resources on the base path. Useful to
     * have a laravel folder structure inside the "overrides" folder and
     * then they will override any file path that is defined inside that
     * folder.
     */
    protected function overrideResources()
    {
        $this->publishes([
            $this->dir.'/../resources/overrides/' => base_path('/'),
        ]);
    }

    /**
     * Replaces the current alias namespace with a new target path.
     *
     * @return void
     */
    protected function customViewNamespace(string $namespace, string $alias)
    {
        view()->getFinder()->replaceNamespace($alias, $namespace);
    }

    /**
     * Extra routes loading.
     *
     * @return void
     */
    protected function extraRoutes(string $path)
    {
        Route::middleware(['web'])
            ->group(function () use ($path) {
                include $path;
            });
    }
}
