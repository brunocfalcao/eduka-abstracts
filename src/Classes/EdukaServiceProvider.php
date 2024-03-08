<?php

namespace Eduka\Abstracts\Classes;

use Eduka\Nereus\Facades\Nereus;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class EdukaServiceProvider extends ServiceProvider
{
    protected $dir;

    public function boot()
    {
        $this->overrideResources();

        if (Nereus::course()) {
            Vite::macro('resource', function (string $path) {
                return $this->asset("resources/assets/{$path}");
            });

            Vite::macro('image', function (string $asset) {
                return $this->asset("resources/assets/images/{$asset}");
            });

            Vite::macro('favicon', function (string $asset) {
                return $this->asset("resources/assets/favicons/{$asset}");
            });

            Vite::useBuildDirectory('vendor/'.Nereus::course()->canonical);
            $this->customViewNamespace($this->dir.'/../resources/views', 'course');
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
