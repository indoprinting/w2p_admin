<?php

namespace App\View\Composer;

use App\Models\Menu\CategoryMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {
        $role = Auth()->user()->role;
        if ($role == 1) :
            $view->with('sidebar_menu', cache()->rememberForever('sidebar_menu', function () {
                return CategoryMenu::with(['menu' => function ($q) {
                    return $q->orderBy('name', 'asc');
                }])->get();
            }));
        else :
            $view->with('sidebar_menu', cache()->rememberForever("sidebar_menu{$role}", function () {
                $role = Auth()->user()->role;
                return CategoryMenu::whereHas('access', fn ($query) => $query->where(['role_id' => $role, 'granted' => 1]))
                    ->with(['menu' => function ($query) use ($role) {
                        return $query->whereHas('access', fn ($query) => $query->where(['role_id' => $role, 'granted' => 1]));
                    }])->get();
            }));
        endif;
    }
}
