<?php
use App\Http\Controllers\barang\BarangController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\pesanan\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\riwayat\RiwayatController;
use App\Services\TelegramService;
use App\Services\XenditService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/stokbarang', [BarangController::class,'index'])->name('barang.index');
Route::get('/stokbarang/tambahbarang', [BarangController::class,'create']);
Route::post('/stokbarang/tambahbarang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/stokbarang/detail/{nama}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/stokbarang/{nama}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/stokbarang/{nama}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/stokbarang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');


Route::get('/datapesanan', [PesananController::class, 'index']);
Route::get('/datapesanan/{nomor_invoice}', [PesananController::class, 'show']);

Route::get('/riwayatpesanan', [RiwayatController::class, 'index']);
Route::get('/riwayatpesanan/{nomor_invoice}', [RiwayatController::class, 'show']);

Route::get('/test-xendit', function (
    XenditService $xendit,
    TelegramService $telegram
) {
    abort_unless(app()->environment('local'), 404);

    $qr = $xendit->createDynamicQr(
        1500,
        'TEST-' . uniqid()
    );

    $telegram->sendMessage(
        "TES QRIS XENDIT BERHASIL\n" .
        "Reference: " . $qr['reference_id'] . "\n" .
        "QR ID: " . $qr['id'] . "\n" .
        "Nominal: Rp" . number_format(
            $qr['amount'],
            0,
            ',',
            '.'
        ) . "\n\n" .
        "Data QR tersedia. Tahap berikutnya adalah " .
        "mengirim gambar QRIS yang bisa dipindai."
    );

    return response()->json([
        'success' => true,
        'message' => 'QRIS berhasil dibuat dan info dikirim ke Telegram.',
        'qr_id' => $qr['id'],
        'reference_id' => $qr['reference_id'],
        'amount' => $qr['amount'],
        'status' => $qr['status'],
    ]);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

