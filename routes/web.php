<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Common\AjaxController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\EditorOnlineController;
use App\Http\Controllers\Order\ExpiredController;
use App\Http\Controllers\Order\OverdueController;
use App\Http\Controllers\Order\DeliveryController;
use App\Http\Controllers\Setting\BannerController;
use App\Http\Controllers\Setting\DesignController;
use App\Http\Controllers\Setting\OutletController;
use App\Http\Controllers\Developer\AdminController;
use App\Http\Controllers\Developer\ErrorController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Setting\OurWorkController;
use App\Http\Controllers\Shipping\GosendController;
use App\Http\Controllers\Developer\RatingController;
use App\Http\Controllers\Setting\WhatsappController;
use App\Http\Controllers\Setting\PriceListController;
use App\Http\Controllers\Order\RecapMonthlyController;
use App\Http\Controllers\Product\BestSellerController;
use App\Http\Controllers\Developer\DeveloperController;
use App\Http\Controllers\Shipping\RajaOngkirController;
use App\Http\Controllers\Product\ReviewProductController;
use App\Http\Controllers\Setting\CommonSettingController;
use App\Http\Controllers\Order\PeformanceOnlineController;
use App\Http\Controllers\Product\CategoryProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['guest'])->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});
Route::middleware(['auth'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    // ------------------------------DASHBOARD--------------------------------------
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('syn-status', [DashboardController::class, 'syncStatusSale'])->name('sync.status');
    Route::get('print-invoice', [DashboardController::class, 'printInvoice'])->name('print.invoice');
    Route::get('print-invoice-operator', [DashboardController::class, 'printInvoiceOperator'])->name('invoice.operator');
    Route::get('print-approval-operator', [DashboardController::class, 'approvalOperator'])->name('approval.operator');
    //AJAX NOTIFICATION
    Route::post('notification-sale', [AjaxController::class, 'notifSale']);
    Route::post('notification-rajaongkir', [AjaxController::class, 'notifRajaOngkir']);
    Route::post('notification-gosend', [AjaxController::class, 'notifGosend']);
    Route::post('notification-tb', [AjaxController::class, 'notifTB']);
    //AJAX ORDER
    Route::post('get-operator', [AjaxController::class, 'getOperators']);
    Route::post('get-tl', [AjaxController::class, 'getTL']);
    //AJAX Regency
    Route::post('get-city', [AjaxController::class, 'ajaxGetCity']);
    Route::post('get-suburb', [AjaxController::class, 'ajaxGetSuburb']);



    // ------------------------------SHIPPING--------------------------------------
    //all shipping
    Route::get('all-shipping', [RajaOngkirController::class, 'allShipping'])->name('all.shipping');
    //rajaongkir
    Route::get('shipping-rajaongkir', [RajaOngkirController::class, 'index'])->name('rajaongkir');
    Route::get('cetak-shipping-invoice', [RajaOngkirController::class, 'printShipping'])->name('print.shipping');
    Route::get('tandai-terkirim/{id}', [RajaOngkirController::class, 'markSend'])->name('dikirim');
    Route::post('detail-rajaongkir', [RajaOngkirController::class, 'detailRajaOngkir'])->name('detail.rajaongkir');
    Route::post('update-resi-shipping', [RajaOngkirController::class, 'updateResi'])->name('update.resi');
    Route::post('update-resi-keterangan', [RajaOngkirController::class, 'updateKeterangan'])->name('update.keterangan');
    Route::post('export-shipping', [RajaOngkirController::class, 'exportShipping'])->name('export.shipping');
    //estimate cost
    Route::get('estimasi-ongkir', [RajaOngkirController::class, 'estimateCost'])->name('estimate.cost');
    //gosend
    Route::get('shipping-gosend', [GosendController::class, 'index'])->name('gosend');
    Route::get('get-driver-gosend/{id}', [GosendController::class, 'getDriver'])->name('get.driver');
    Route::get('cancel-gosend/{resi}', [GosendController::class, 'cancelGosend'])->name('cancel.gosend');
    Route::get('cek-gosend/{resi}', [GosendController::class, 'cekGosend'])->name('cek.gosend');
    
    Route::get('hapus-order/{id}', [GosendController::class, 'hapusOrder'])->name('hapus.order');

    // ------------------------------ORDER--------------------------------------
    Route::get('semua-transaksi', [OrderController::class, 'index'])->name('order');
    Route::get('detail-transaksi/{order}', [OrderController::class, 'detail'])->name('order.detail');
    Route::get('hapus-transaksi', [OrderController::class, 'destroy'])->name('order.delete');
    Route::get('complete-transaksi', [OrderController::class, 'completeOrder'])->name('order.complete');
    Route::get('proses-invoice', [OrderController::class, 'procedInvoice'])->name('proced');
    Route::get('update-tb', [OrderController::class, 'sendTB'])->name('update.tb');
    Route::get('approve-nota', [OrderController::class, 'approvedInvoice'])->name('approved.invoice');
    Route::get('send-wa-paid', [OrderController::class, 'waPaid'])->name('wa.paid');
    Route::post('update-invoice', [OrderController::class, 'updateInvoice'])->name('update.invoice');
    Route::post('manual-validasi', [OrderController::class, 'manualValidation'])->name('manual.validation');
    Route::post('manual-validasi-qris', [OrderController::class, 'manualValidationQris'])->name('manual.validation.qris');
    //download
    Route::get('download-bukti-transfer', [OrderController::class, 'downloadBuktiTransfer'])->name('payment.proof');
    Route::get('download-design', [OrderController::class, 'downloadDesign'])->name('download.design');
    Route::get('download-design-online', [OrderController::class, 'downloadDesignOnline'])->name('download.design.online');
    //create
    Route::get('invoice-w2p', [OrderController::class, 'create'])->name('create.order');
    Route::post('save-invoice-w2p', [OrderController::class, 'storeOrder'])->name('store.order');
    // ------------------------------DELIVERY LIST--------------------------------------
    Route::get('delivery-list', [DeliveryController::class, 'index'])->name('tb');
    Route::post('export-delivery-list', [DeliveryController::class, 'exportDelivery'])->name('export.delivery');
    // ------------------------------EXPIRED LIST--------------------------------------
    Route::get('expired-list', [ExpiredController::class, 'index'])->name('expired');

    // ------------------------------SUMMARY--------------------------------------
    // RECAP MONTHLY
    Route::get('recap-bulanan', [RecapMonthlyController::class, 'index'])->name('recap.monthly');
    Route::get('recap-order-bulanan', [RecapMonthlyController::class, 'recapOrder'])->name('recap.order');
    Route::get('recap-tim-online', [PeformanceOnlineController::class, 'rekapTimOnline'])->name('recap.online');
    Route::post('export-recap-bulanan', [RecapMonthlyController::class, 'exportRecap'])->name('export.recap');
    Route::post('edit-date', [RecapMonthlyController::class, 'updateDate'])->name('edit.recap.monthly');
    // BEST SELLER
    Route::get('produk-terlaris', [BestSellerController::class, 'index'])->name('best.seller');
    //OVERDUE
    Route::get('overdue-get', [OverdueController::class, 'index'])->name('overdue.get');
    Route::get('invalid-overdue-get', [OverdueController::class, 'invalidOverdue'])->name('overdue.invalid');

    // ------------------------------PRODUCT--------------------------------------
    Route::get('peforma-tim-online', [PeformanceOnlineController::class, 'index'])->name('perform.online');
    Route::post('set-target-tim-online', [PeformanceOnlineController::class, 'setTarget'])->name('set.target');

    // ------------------------------PRODUCT--------------------------------------
    // Route::get('semua-produk', [ProductController::class, 'index'])->name('product');
    Route::resource('product', ProductController::class)->names('product');
    Route::get('create-product-book', [ProductController::class, 'create'])->name('product.book');
    Route::get('create-product-sticker', [ProductController::class, 'create'])->name('product.sticker');
    Route::get('sync-product', [ProductController::class, 'syncProductERP'])->name('product.sync');
    Route::get('duplicate-product/{id}', [ProductController::class, 'duplicate'])->name('product.duplicate');
    Route::get('set-product', [ProductController::class, 'activeProduct'])->name('product.active');
    Route::get('export-product', [ProductController::class, 'exportProduct'])->name('product.export');
    Route::get('download-image-product', [ProductController::class, 'downloadImage'])->name('download.image.product');
    // Review product
    Route::get('review-produk', [ReviewProductController::class, 'index'])->name('review.product');
    Route::post('update-respon-review', [ReviewProductController::class, 'updateRespon'])->name('update.response');
    // Category product
    Route::resource('kategori-produk', CategoryProductController::class)->names('category.product');

    // ------------------------------CUSTOMER--------------------------------------
    Route::get('semua-pelanggan', [CustomerController::class, 'index'])->name('customer');
    Route::get('detail-belanja/{id}', [CustomerController::class, 'detail'])->name('detail.belanja');
    Route::post('ganti-password', [CustomerController::class, 'changePassword'])->name('change.password');

    // ------------------------------DESIGN--------------------------------------
    Route::get('clipart', [VisitorController::class, 'index'])->name('clipart');
    Route::get('design-online', [EditorOnlineController::class, 'index'])->name('editor.online');
    Route::get('get-template', [EditorOnlineController::class, 'getDesign'])->name('get.design');
    Route::get('delete-design', [EditorOnlineController::class, 'destroy'])->name('delete.design');
    Route::post('save-design-online', [EditorOnlineController::class, 'store'])->name('store.design');
    //create product design
    Route::get('create-product-design', [EditorOnlineController::class, 'createDesign'])->name('product.design');
    Route::post('save-product-design', [EditorOnlineController::class, 'saveProductDesign'])->name('save.product.design');
    //fonts
    Route::get('w2p-font', [EditorOnlineController::class, 'fonts'])->name('w2p.font');
    Route::post('save-font', [EditorOnlineController::class, 'storeFont'])->name('store.font');
    //setting w2p
    Route::get('w2p-setting', [EditorOnlineController::class, 'w2pSettings'])->name('w2p.setting');
    Route::post('insert-update-setting', [EditorOnlineController::class, 'setSetting'])->name('set.setting');

    // ------------------------------VISITOR--------------------------------------
    Route::get('visitor', [VisitorController::class, 'index'])->name('visitor');
    Route::get('daily-visitor', [VisitorController::class, 'dailyVisitor'])->name('daily.visitor');

    // ------------------------------SETTING--------------------------------------
    Route::prefix('setting')->group(function () {
        //BANNER
        Route::resource('banner', BannerController::class)->names('banner');
        Route::get('delete-banner/{id}', [BannerController::class, 'destroy'])->name('banner.delete');
        Route::get('active-banner', [BannerController::class, 'activeBanner'])->name('banner.active');
        Route::get('main-banner', [BannerController::class, 'mainBanner'])->name('banner.main');
        Route::post('shorting-banner', [BannerController::class, 'shortingBanner'])->name('banner.shorting');
        //rapiwha
        Route::get('blacklist-wa-otomatis', [WhatsappController::class, 'index'])->name('rapiwha');
        Route::get('blacklist-wa-otomatis/delete', [WhatsappController::class, 'destroy'])->name('rapiwha.delete');
        Route::post('blacklist-wa-otomatis/save', [WhatsappController::class, 'store'])->name('rapiwha.store');
        Route::post('blacklist-wa-otomatis/edit', [WhatsappController::class, 'edit'])->name('rapiwha.edit');
        //OURWORK
        Route::get('ourwork', [OurWorkController::class, 'index'])->name('ourwork');
        Route::get('ourwork/delete', [OurWorkController::class, 'destroy'])->name('ourwork.destroy');
        Route::post('ourwork/save', [OurWorkController::class, 'store'])->name('ourwork.store');
        //OUTLET
        Route::get('outlet', [OutletController::class, 'index'])->name('outlet');
        Route::get('set-active-outlet', [OutletController::class, 'setActive'])->name('set.active');
        Route::post('outlet', [OutletController::class, 'update'])->name('outlet.update');
        //PRICE LIST
        Route::get('price-list', [PriceListController::class, 'index'])->name('price.list');
        Route::get('price-list/delete', [PriceListController::class, 'destroy'])->name('price.list.delete');
        Route::post('price-list/store', [PriceListController::class, 'store'])->name('price.list.store');
        //COMMON SETTING
        Route::get('/', [CommonSettingController::class, 'index'])->name('setting');
        Route::post('tentang-indoprinting', [CommonSettingController::class, 'updateAboutIDP'])->name('about.idp');
        Route::post('kebijakan-dan-privasi', [CommonSettingController::class, 'updatePrivacy'])->name('privacy');
        Route::post('syarat-dan-ketentuan', [CommonSettingController::class, 'updateTerm'])->name('term');
        Route::post('promosi-halaman-login', [CommonSettingController::class, 'updatePromo'])->name('promo');
        //DESIGN 
        Route::get('design-w2p', [DesignController::class, 'index'])->name('design');
        Route::get('delete-design-w2p', [DesignController::class, 'destroy'])->name('destroy.design');
        Route::post('store-design-w2p', [DesignController::class, 'store'])->name('store.design');
        Route::post('update-design-w2p', [DesignController::class, 'update'])->name('update.design');
    });
    // ------------------------------SUPER ADMIN--------------------------------------
    Route::prefix('developer')->group(function () {
        //ADMIN 
        Route::get('admin-list', [AdminController::class, 'index'])->name('admin.list');
        Route::get('admin-list/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
        Route::post('admin-list/add', [AdminController::class, 'store'])->name('admin.store');
        Route::post('admin-list/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        //MENU ADMIN
        Route::get('menu-admin', [MenuController::class, 'index'])->name('menu.admin');
        Route::get('delete-admin', [MenuController::class, 'destroy'])->name('menu.delete');
        Route::post('save-admin', [MenuController::class, 'store'])->name('menu.store');
        Route::post('update-admin', [MenuController::class, 'update'])->name('menu.update');
        //USER ACCESS
        Route::get('user-access/{role}', [MenuController::class, 'accessList'])->name('menu.access');
        Route::get('grant-access-category', [MenuController::class, 'accessCategory'])->name('access.category');
        Route::get('grant-access-menu', [MenuController::class, 'accessMenu'])->name('access.menu');
        //ADMIN ERROR REPORT
        Route::get('error-report', [ErrorController::class, 'index'])->name('admin.error');
        //RATING
        Route::get('rating-w2p', [RatingController::class, 'index'])->name('rating.w2p');
        Route::post('rating-w2p', [RatingController::class, 'store'])->name('rating.store');
    });
});

Route::get('check-old-carts', [ExpiredController::class, 'checkOldCarts'])->name('old.carts');
Route::get('check-old-orders', [ExpiredController::class, 'checkOldOrders'])->name('old.orders');


Route::get('clear-cache-admin', [DeveloperController::class, 'clearCache'])->name('cache.admin');
Route::get('clear-cache-product-erp', [DeveloperController::class, 'clearCacheProductERP'])->name('cache.product.erp');
Route::get('clear-cache', function () {
    Artisan::call('cache:clear');
    return back();
})->name('clear.cache');
Route::get('test-wa', function () {
    return waPaid('123', '089675465400', '2022-04-12', 22);
});
Route::get('optimize', function () {
    Artisan::call('optimize');
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    return Artisan::call('view:cache');
});

Route::get('set-payment', function () {
    $get_setting = DB::table('adm_settings')->where('setting_name', 'set_payment')->value('setting');
    if ($get_setting == 0) {
        DB::table('adm_settings')->where('setting_name', 'set_payment')->update(['setting' => 1]);
        return back()->with('warning', 'Checkout aktif');
    } else {
        DB::table('adm_settings')->where('setting_name', 'set_payment')->update(['setting' => 0]);
        return back()->with('warning', 'Checkout non-aktif');
    }
});
