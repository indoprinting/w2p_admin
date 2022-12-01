<?php

namespace App\View\Composer;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class setPaymentComposer
{
    public function compose(View $view)
    {
        $set_payment = DB::table('adm_settings')->where('setting_name', 'set_payment')->value('setting');

        $view->with('set_payment', $set_payment);
    }
}
