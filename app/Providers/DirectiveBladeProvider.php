<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DirectiveBladeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('role', function ($arguments) {
            return "<?php if (auth()->check() && in_array(auth()->user()->role, {$arguments})): ?>";
        });

        Blade::directive('elserole', function () {
            return '<?php else: ?>';
        });

        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });
    }
}
