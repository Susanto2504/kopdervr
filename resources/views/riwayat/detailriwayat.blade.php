
<x-layout.layout :title="'Detail Pesanan'">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ url('/riwayatpesanan') }}"
                class="mb-3 inline-flex items-center gap-2 text-xs font-medium text-gray-500 hover:text-[#DF301C]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Pesanan
            </a>

            <h1 class="text-xl font-bold text-gray-800">
                Detail Pesanan
            </h1>

            <p class="mt-1 text-xs text-gray-400">
                Invoice #{{ $pesanan->nomor_invoice }}
            </p>
        </div>

        <span class="inline-flex w-fit rounded-full px-4 py-2 text-xs font-semibold
            {{ strtoupper($pesanan->status_pembayaran) === 'LUNAS'
                ? 'bg-green-100 text-green-700'
                : 'bg-[#FFF1D1] text-[#FF9100]' }}">
            {{ ucfirst(strtolower($pesanan->status_pembayaran)) }}
        </span>
    </div>

    {{-- INFORMASI UTAMA --}}
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

        {{-- INFORMASI PELANGGAN --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 lg:col-span-2">
            <h2 class="mb-5 text-sm font-bold text-gray-800">
                Informasi Pelanggan
            </h2>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <p class="text-xs text-gray-400">Nama Pelanggan</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $pesanan->nama_penerima ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Nomor Invoice</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $pesanan->nomor_invoice }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Nama Penerima</p>
                    <p class="mt-1 text-sm font-medium text-gray-700">
                        {{ $pesanan->nama_penerima }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Nomor Telepon Penerima</p>
                    <p class="mt-1 text-sm font-medium text-gray-700">
                        {{ $pesanan->nomor_telepon_penerima }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-400">Alamat Pengiriman</p>
                    <p class="mt-1 text-sm leading-6 text-gray-700">
                        {{ $pesanan->alamat_pengiriman }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Tanggal Pesanan</p>
                    <p class="mt-1 text-sm font-medium text-gray-700">
                        {{ $pesanan->tanggal_pesanan
                            ? \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y, H:i')
                            : '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Metode Pembayaran</p>
                    <p class="mt-1 text-sm font-medium text-gray-700">
                        {{ $pesanan->metode_pembayaran ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Metode Pengiriman</p>
                    <p class="mt-1 text-sm font-medium text-gray-700">
                        {{ $pesanan->metode_pengiriman ?? '-' }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-400">Catatan Pelanggan</p>
                    <p class="mt-1 text-sm leading-6 text-gray-700">
                        {{ $pesanan->catatan_pelanggan ?: 'Tidak ada catatan.' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- RINGKASAN PEMBAYARAN --}}
        <div class="h-fit rounded-xl border border-gray-200 bg-white p-5">
            <h2 class="mb-5 text-sm font-bold text-gray-800">
                Ringkasan Pembayaran
            </h2>

            <div class="space-y-4 text-xs">

                <div class="flex items-center justify-between gap-3">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium text-gray-800">
                        Rp{{ number_format($pesanan->subtotal, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex items-center justify-between gap-3">
                    <span class="text-gray-500">Biaya Pengiriman</span>
                    <span class="font-medium text-gray-800">
                        Rp{{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex items-center justify-between gap-3">
                    <span class="text-gray-500">Diskon</span>
                    <span class="font-medium text-green-600">
                        -Rp{{ number_format($pesanan->diskon, 0, ',', '.') }}
                    </span>
                </div>

                <div class="border-t border-dashed border-gray-200 pt-4">
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-semibold text-gray-700">
                            Total Pembayaran
                        </span>
                        <span class="text-base font-bold text-[#DF301C]">
                            Rp{{ number_format($pesanan->total_pembayaran, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

    </div>

    
    {{-- DAFTAR BARANG PESANAN --}}
    <div class="mt-5 rounded-xl border border-gray-200 bg-white p-5">
        <h2 class="mb-5 text-sm font-bold text-gray-800">
            Daftar Barang Pesanan
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">
                            Nama Barang
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">
                            SKU
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500">
                            Harga
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500">
                            Jumlah
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500">
                            Subtotal
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pesanan->detailPesanan as $detail)
                        <tr class="border-b border-gray-100">
                            <td class="px-4 py-3 text-xs font-medium text-gray-800">
                                {{ $detail->nama_barang }}
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500">
                                {{ $detail->sku }}
                            </td>
                            <td class="px-4 py-3 text-right text-xs text-gray-700">
                                Rp{{ number_format($detail->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center text-xs text-gray-700">
                                {{ $detail->jumlah }}
                            </td>
                            <td class="px-4 py-3 text-right text-xs font-semibold text-gray-800">
                                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-xs text-gray-400">
                                Belum ada detail barang untuk pesanan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- RIWAYAT STATUS --}}
    <div class="mt-5 rounded-xl border border-gray-200 bg-white p-5">
        <h2 class="mb-5 text-sm font-bold text-gray-800">
            Riwayat Status Pesanan
        </h2>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

            @php
                $riwayatStatus = [
                    'Pesanan Dibuat' => $pesanan->tanggal_pesanan,
                    'Dikonfirmasi' => $pesanan->dikonfirmasi_pada,
                    'Diproses' => $pesanan->diproses_pada,
                    'Dikirim' => $pesanan->dikirim_pada,
                    'Diterima' => $pesanan->diterima_pada,
                    'Dibatalkan' => $pesanan->dibatalkan_pada,
                ];
            @endphp

            @foreach ($riwayatStatus as $status => $tanggal)
                <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                    <p class="text-xs font-medium text-gray-700">
                        {{ $status }}
                    </p>

                    <p class="mt-2 text-xs {{ $tanggal ? 'text-gray-600' : 'text-gray-400' }}">
                        {{ $tanggal
                            ? \Carbon\Carbon::parse($tanggal)->format('d M Y, H:i')
                            : 'Belum tercatat' }}
                    </p>
                </div>
            @endforeach

        </div>
    </div>

</x-layout.layout>
