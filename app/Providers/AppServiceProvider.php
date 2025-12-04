<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $menuConfig = config('menu', []);
            $user = auth()->user();

            // roleName fallback null jika guest
            $roleName = $user ? optional($user->role)->role : null;

            // filter menu berdasarkan role
            $filtered = [];
            foreach ($menuConfig as $block) {
                $items = [];
                foreach ($block['items'] as $item) {
                    // tampilkan jika roles contain roleName (guest tidak lihat apapun)
                    if ($roleName && in_array($roleName, $item['roles'], true)) {
                        $items[] = $item;
                    }
                }
                if (!empty($items)) {
                    $filtered[] = [
                        'header' => $block['header'] ?? null,
                        'items' => $items,
                    ];
                }
            }

            $view->with('sidebarMenu', $filtered);
        });
    }
}
