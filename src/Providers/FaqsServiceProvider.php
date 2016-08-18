<?php

namespace Mixdinternet\Faqs\Providers;

use Illuminate\Support\ServiceProvider;
use Mixdinternet\Faqs\Faq;

use Menu;

class FaqsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setMenu();

        $this->setRoutes();

        $this->setRouterBind();

        $this->loadViews();

        $this->publish();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       #$this->mergeConfigFrom(__DIR__ . '/../config/maudit.php', 'maudit.alias');
    }

    protected function setMenu()
    {
        Menu::modify('adminlte-sidebar', function ($menu) {
            $menu->route('admin.faqs.index', 'Faqs', [], 20
                , ['icon' => config('mfaqs.icon', 'fa fa-question'), 'active' => function () {
                    return checkActive(route('admin.faqs.index'));
                }])->hideWhen(function () {
                return checkRule('admin.faqs.index');
            });
        });

        Menu::modify('adminlte-permissions', function ($menu) {
            $menu->url('admin.faqs', 'Faqs', 20);
        });
    }

    protected function setRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $this->app->router->group(['namespace' => 'Mixdinternet\Faqs\Http\Controllers'],
                function () {
                    require __DIR__ . '/../Http/routes.php';
                });
        }
    }

    protected function setRouterBind()
    {
        $this->app->router->bind('faqs', function ($id) {
            $faq = Faq::find($id);
            if (!$faq) {
                abort(404);
            }

            return $faq;
        });
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mixdinternet/faqs');
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
