<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\MenuLocation;
use App\Services\MenuService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->initSuperAdmin();
        $this->bootMacros();
        $this->registerAdminMenu();
        Model::preventLazyLoading(! app()->isProduction());
    }

    public function initSuperAdmin(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }

    protected function registerAdminMenu(): void
    {
        View::composer(['layouts.partials.left-sidebar', 'admin.dashboard'], function ($view) {
            $menuService = new MenuService();

            $view->with([
                'menuAdminHTML' => $menuService->displayAdminMenu(MenuLocation::ADMIN),
            ]);
        });
    }

    protected function bootMacros(): void
    {
        Component::macro('toast', function ($text) {
            $this->js(<<<JS
                Swal.fire({
                    toast: true,
                    position: 'top-right',
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: '{$text}'
                })
            JS);
        });
    }
}
