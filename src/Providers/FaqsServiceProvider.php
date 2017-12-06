<?php

namespace Mixdinternet\Faqs\Providers;

use Illuminate\Support\ServiceProvider;
use Mixdinternet\Faqs\Faq;
use Menu;

class FaqsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->setMenu();

        $this->setRoutes();

        $this->loadViews();

        $this->loadMigrations();

        $this->publish();
    }

    public function register()
    {
        $this->loadConfigs();
    }

    protected function setMenu()
    {
        Menu::modify('adminlte-sidebar', function ($menu) {
            $menu->route('admin.faqs.index', config('mfaqs.name', 'Faqs'), [], config('marticles.order', 20)
                , ['icon' => config('mfaqs.icon', 'fa fa-question'), 'active' => function () {
                    return checkActive(route('admin.faqs.index'));
                }])->hideWhen(function () {
                return checkRule('admin.faqs.index');
            });
        });

        Menu::modify('adminlte-permissions', function ($menu) {
            $menu->url('admin.faqs', config('mfaqs.name', 'Faqs'), config('marticles.order', 20));
        });
    }

    protected function setRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $this->app->router->group(['namespace' => 'Mixdinternet\Faqs\Http\Controllers'],
                function () {
                    require __DIR__ . '/../routes/web.php';
                });
        }
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mixdinternet/faqs');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/maudit.php', 'maudit.alias');
        $this->mergeConfigFrom(__DIR__ . '/../config/mfaqs.php', 'mfaqs');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/mixdinternet/faqs'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../database/migrations' => base_path('database/migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/mfaqs.php' => base_path('config/mfaqs.php'),
        ], 'config');
    }
}
