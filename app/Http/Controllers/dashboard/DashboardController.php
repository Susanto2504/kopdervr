<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. TOTAL BARANG
        $totalBarang = Barang::count();

        // 2. TOTAL PEMESANAN
        $totalPesanan = Pesanan::count();

        // 3. STOK MENIPIS
        $stokMenipis = Barang::whereColumn(
            'stok',
            '<=',
            'batas_stok_minimum'
        )->count();

        // 4. PESANAN DIPROSES
        $pesananDiproses = Pesanan::where(
            'status_pesanan',
            'diproses'
        )->count();

        // 5. PESANAN TERKIRIM BULAN INI
        $awalBulan = Carbon::now()->startOfMonth();
        $sekarang = Carbon::now();

        $pesananTerkirim = Pesanan::where(
            'status_pesanan',
            'terkirim'
        )
            ->whereBetween('created_at', [$awalBulan, $sekarang])
            ->count();

            // 6. DATA GRAFIK PESANAN PER BULAN
            $tahun = Carbon::now()->year;

            $dataPesanan = Pesanan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
                ->whereYear('created_at', $tahun)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('bulan')
                ->pluck('total', 'bulan');

            // Menyiapkan 12 bulan
            $namaBulan = [
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'Mei',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Agu',
                9 => 'Sep',
                10 => 'Okt',
                11 => 'Nov',
                12 => 'Des',
            ];
            $chartData = [];

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $chartData[] = [
                    'bulan' => $namaBulan[$bulan],
                    'total' => (int) ($dataPesanan[$bulan] ?? 0),
                ];
            }

            // Menghitung tinggi batang grafik
            $maksimalPesanan = max(
                array_column($chartData, 'total') ?: [0]
            );

            foreach ($chartData as &$item) {
                $item['height'] = $maksimalPesanan > 0
                    ? ($item['total'] / $maksimalPesanan) * 100
                    : 0;
            }

            unset($item);

        // 9. MENAMPILKAN DASHBOARD
        return view('beranda.beranda', compact(
            'totalBarang',
            'totalPesanan',
            'stokMenipis',
            'pesananDiproses',
            'pesananTerkirim',
            'chartData'
        ))->with('title', 'Dashboard');
    }
}
