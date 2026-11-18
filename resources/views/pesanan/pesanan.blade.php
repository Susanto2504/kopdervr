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
    </div>

    <div class="mt-4 flex flex-wrap gap-2">
        {{-- SEMUA --}}
        <button class="rounded-full bg-[#17181C] px-4 py-2 text-xs font-medium text-white">Semua <span class="ml-1 text-gray-300">48</span></button>

        {{-- BARU --}}
        <button class="rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-medium text-gray-600 transition hover:border-gray-300">Baru <span class="ml-1 text-gray-400">12</span></button>

        {{-- DIPROSES --}}
        <button class="rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-medium text-gray-600 transition hover:border-gray-300">Diproses<span class="ml-1 text-gray-400">18</span></button>

        {{-- SIAP DIKIRIM --}}
        <button class="rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-medium text-gray-600 transition hover:border-gray-300">Siap dikirim <span class="ml-1 text-gray-400">8</span></button>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">   
                {{-- TABLE HEADER --}}
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Pelanggan & Alamat</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tanggal</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Aksi</th>
                    </tr>
                </thead>

                {{-- TABLE BODY --}}
                <tbody>
                    @foreach ($pesanans as $pesan)
                        <tr class="border-b border-gray-200 transition hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div>
                                    <p class="text-xs font-semibold text-gray-800">{{ $pesan->nama_penerima }} · #{{ $pesan['nomor_invoice'] }}</p>
                                    <p class="mt-1 text-xs text-gray-400">{{$pesan->alamat_pengiriman}}</p>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="rounded-full px-3 py-1 text-xs font-medium
                                    {{ $pesan['status_pembayaran'] === 'LUNAS'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-[#FFF1D1] text-[#FF9100]' }}">
                                    {{ $pesan['status_pembayaran'] }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <span class="text-xs text-gray-400">{{ $pesan['tanggal_pesanan'] }}</span>
                            </td>

                            <td class="px-4 py-3 text-right">
                                <a href="{{ url('/datapesanan/' . $pesan->nomor_invoice) }}" class="text-xs font-semibold text-[#DF301C] hover:underline">Lihat Detail</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout.layout>
