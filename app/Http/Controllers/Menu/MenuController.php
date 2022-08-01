<?php

namespace App\Http\Controllers\Menu;

use App\Models\Menu\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Menu\CategoryMenu;
use App\Models\Menu\UserAccess;
use App\Models\UserRole;

class MenuController extends Controller
{
    protected $menu_model;
    public function __construct()
    {
        $this->menu_model = new Menu();
    }

    public function index()
    {
        $title      = "Daftar Menu";
        $menus      = $this->menu_model->getMenu();
        $categories = CategoryMenu::get();
        $roles      = UserRole::whereNotIn('id', [1])->get();

        return view('developer.menu.index_menu', compact('title', 'menus', 'categories', 'roles'));
    }

    public function store(Request $request)
    {
        clearCache();
        Menu::create([
            'name'  => $request->name,
            'icon'  => $request->icon,
            'route' => $request->route,
            'category_id' => $request->category_id,
        ]);

        return back()->with('success', 'Berhasil menambah Menu');
    }

    public function update(Request $request)
    {
        clearCache();
        Menu::where('id', $request->id)->update([
            'name'  => $request->name,
            'icon'  => $request->icon,
            'route' => $request->route,
            'category_id' => $request->category_id,
        ]);

        return back()->with('success', 'Berhasil mengupdate Menu');
    }

    public function destroy(Request $request)
    {
        clearCache();
        Menu::where('id', $request->id)->delete();
        return back()->with('warning', 'Berhasil hapus menu');
    }

    public function accessList($role)
    {
        $role_name  = UserRole::where('id', $role)->value('user_role');
        $title      = "Role Access $role_name";
        $categories = CategoryMenu::with(['menu' => function ($query) use ($role) {
            return $query->with(['access' => fn ($query) => $query->where('role_id', $role)]);
        }, 'access' => fn ($query) => $query->where('role_id', $role)])->get();

        return view('developer.menu.role_access', compact('title', 'categories', 'role'));
    }

    public function accessCategory(Request $request)
    {
        $category_id    = $request->category_id;
        $role_id        = $request->role_id;
        $granted        = $request->granted == 1 ? 0 : 1;
        UserAccess::updateOrCreate(
            ['category_id' => $category_id, 'role_id' => $role_id],
            ['granted' => $granted]
        );

        return back();
    }

    public function accessMenu(Request $request)
    {
        $menu_id    = $request->menu_id;
        $role_id    = $request->role_id;
        $granted    = $request->granted == 1 ? 0 : 1;
        UserAccess::updateOrCreate(
            ['menu_id' => $menu_id, 'role_id' => $role_id],
            ['granted' => $granted]
        );

        return back();
    }
}
