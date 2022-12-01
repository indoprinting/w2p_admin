<?php

namespace App\View\Composer;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cookie;

class ThemeComposer
{
    public function compose(View $view)
    {
        $theme = Cookie::get('theme');
        if ($theme != 'dark' && $theme != 'light') {
            $theme = 'light';
        }

        $view->with('theme', $theme);
    }
}
