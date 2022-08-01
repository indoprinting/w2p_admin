<?php

use App\Http\Controllers\Webhook\GosendWebhookController;
use App\Http\Controllers\Webhook\PrintERPWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/printerp-sales', [PrintERPWebhookController::class, 'salesERP']);
Route::post('v1/webhook-gosend', [GosendWebhookController::class, 'GosendIntegration']);
Route::post('production/webhook-gosend', [GosendWebhookController::class, 'GosendProduction']);
