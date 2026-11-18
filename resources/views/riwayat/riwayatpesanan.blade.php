<x-layout.layout :title="$title"> 
    {{-- TOOLBAR --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        {{-- SEARCH --}}
        <div class="relative w-full sm:w-72">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7"/>
                <path d="M20 20L16 16"/>
            </svg>

            <input type="text" placeholder="Cari data..." class="w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-9 pr-3 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">
        </div>

        {{-- ACTION --}}
        <div class="flex items-center gap-2">
            {{-- DATE --}}
            <button class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50">
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="4" y="5" width="16" height="15" rx="2"/>
                    <path d="M8 3V7"/>
                    <path d="M16 3V7"/>
                    <path d="M4 10H20"/>
                </svg>
                01–24 Sep 2026
            </button>

            {{-- EXPORT --}}
            <button class="rounded-lg bg-[#DF301C] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#c92717]">Ekspor riwayat</button>
        </div>
    </div>

    {{-- PESANAN TERKIRIM --}}
    <div class="mt-4 overflow-hidden rounded-xl border border-gray-200 bg-white">
        {{-- TABLE HEADER --}}
        <div class="flex items-center justify-between border-b border-gray-200 px-4 py-4">
            <h3 class="text-sm font-medium text-gray-800">Pesanan sudah terkirim</h3>
            <span class="text-xs text-gray-400">126 pesanan</span>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                {{-- HEADER --}}
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Pelanggan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Pesanan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Pengiriman</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @foreach ($pesanans as $pesan)
                        <tr class="border-b border-gray-200 transition hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="text-xs font-semibold text-[#DF301C]">#{{ $pesan->nomor_invoice }}</p>
                                <p class="mt-1 text-xs font-semibold text-gray-800">{{ $pesan->nama_penerima }}</p>
                            </td>

                            <td class="px-4 py-3">
                                <p class="text-xs font-medium text-gray-700">
                                    {{ $pesan->detailPesanan->first()->nama_barang ?? 'Produk Tidak Diketahui' }}
                                </p>
                                <p class="mt-1 text-xs text-gray-400">{{ $pesan->alamat_pengiriman }}</p>
                            </td>

                            <td class="px-4 py-3">
                                <p class="text-xs font-medium text-gray-700">{{ $pesan->metode_pengiriman }}</p>
                                <p class="mt-1 text-xs text-gray-400">{{ $pesan->tanggal_pesanan ? \Carbon\Carbon::parse($pesan->tanggal_pesanan)->format('d M Y') : '-' }}</p>
                            </td>

                            <td class="px-4 py-3">
                                <span class="rounded-full px-3 py-1 text-xs font-medium
                                    {{ $pesan['status_pembayaran'] === 'LUNAS'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-[#FFF1D1] text-[#FF9100]' }}">
                                    {{ $pesan['status_pembayaran'] }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-right">
                                <a href="{{ url('/riwayatpesanan/' . $pesan->nomor_invoice) }}" class="text-xs font-semibold text-[#DF301C] hover:underline">Lihat Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout.layout>
