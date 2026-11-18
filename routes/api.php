<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PesananUnityController;
use App\Http\Controllers\XenditWebhookController;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/customers', [CustomerController::class, 'store']);

Route::get('/barang', function () {
    $barangs = Barang::query()->where('status', 'aktif')->select(['id', 'nama', 'sku', 'harga_jual', 'stok'])->get();
    return response()->json(['success'=>true, 'data'=>$barangs]);
});

Route::post('/pesanan-unity', [PesananUnityController::class, 'store',]);

Route::post('/webhooks/xendit/qris', [
    XenditWebhookController::class,
    'handle',
]);