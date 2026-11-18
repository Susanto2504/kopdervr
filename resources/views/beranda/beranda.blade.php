
<x-layout.layout :title="$title">

    {{-- WELCOME --}}
    <div class="mb-6">
        <p class="text-xs text-gray-400">
            Selamat datang kembali, Nadia.
        </p>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-2">

        {{-- CARD 1: JUMLAH BARANG --}}
        <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Jumlah Barang</p>
                    <p class="mt-4 text-2xl font-bold text-gray-800">
                        {{ number_format($totalBarang, 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-[#DF301C]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        stroke-width="1.6" viewBox="0 0 24 24">
                        <path d="M21 8.5L12 4 3 8.5V15.5L12 20L21 15.5V8.5Z"/>
                        <path d="M3 8.5L12 13L21 8.5"/>
                        <path d="M12 13V20"/>
                    </svg>
                </div>
            </div>

            <p class="mt-4 text-xs text-gray-400">
                Total seluruh barang terdaftar
            </p>
        </div>

        {{-- CARD 2: PEMESANAN --}}
        <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Total Pemesanan</p>
                    <p class="mt-4 text-2xl font-bold text-gray-800">
                        {{ number_format($totalPesanan, 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#FFF1D1] text-[#FF9100]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        stroke-width="1.6" viewBox="0 0 24 24">
                        <rect x="4" y="5" width="16" height="15" rx="2"/>
                        <path d="M8 3V7"/>
                        <path d="M16 3V7"/>
                        <path d="M4 10H20"/>
                    </svg>
                </div>
            </div>

            <p class="mt-4 text-xs text-gray-400">
                Total seluruh pesanan terdaftar
            </p>
        </div>

    </div>

    {{-- CHART + STATUS PENGIRIMAN --}}
    <div class="mt-5 grid grid-cols-1 gap-5 xl:grid-cols-2">
        
        {{-- GRAFIK PESANAN PER BULAN --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm xl:col-span-2">

            {{-- HEADER --}}
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-6 py-5">
                <div>
                    <h3 class="text-sm font-bold text-gray-800">
                        Ringkasan Pesanan
                    </h3>
                    <p class="mt-1 text-xs text-gray-400">
                        Statistik jumlah pesanan setiap bulan
                    </p>
                </div>

                <div class="flex items-center gap-2 rounded-lg bg-red-50 px-3 py-2">
                    <span class="h-2 w-2 rounded-full bg-[#DF301C]"></span>
                    <span class="text-xs font-semibold text-[#DF301C]">
                        Tahun {{ now()->year }}
                    </span>
                </div>
            </div>

            {{-- CHART CONTENT --}}
            <div class="p-6">

                {{-- TOTAL PESANAN --}}
                <div class="mb-6">
                    <p class="text-xs text-gray-400">
                        Total pesanan tahun {{ now()->year }}
                    </p>

                    <p class="mt-1 text-2xl font-bold text-gray-800">
                        {{ number_format(array_sum(array_column($chartData, 'total')), 0, ',', '.') }}
                        <span class="text-xs font-normal text-gray-400">
                            Pesanan
                        </span>
                    </p>
                </div>

                {{-- CHART --}}
                <div class="overflow-x-auto pb-2">
                    <div class="min-w-[500px]">

                        {{-- AREA GRAFIK --}}
                        <div class="relative h-52">

                            {{-- GRID --}}
                            <div class="pointer-events-none absolute inset-0 flex flex-col justify-between">
                                @foreach (range(0, 3) as $line)
                                    <div class="w-full border-t border-dashed border-gray-100"></div>
                                @endforeach
                            </div>
    
                            {{-- BARS --}}
                            <div class="relative z-10 flex h-full items-end justify-between gap-3 px-2">

                                @foreach ($chartData as $item)
                                    <div
                                        class="group relative flex h-full flex-1 items-end justify-center"
                                        tabindex="0"
                                    >

                                        {{-- BAR --}}
                                        <div
                                            class="w-full max-w-[32px] rounded-t-lg transition-all duration-300 ease-out
                                                {{ $item['total'] > 0
                                                    ? 'bg-gradient-to-t from-[#DF301C] to-[#FFB36B] opacity-90 group-hover:opacity-100 group-hover:shadow-md group-hover:shadow-red-100'
                                                    : 'bg-gray-100' }}"
                                            style="height: {{ $item['height'] }}%; min-height: {{ $item['total'] > 0 ? '4px' : '0' }};"
                                        ></div>

                                        {{-- TOOLTIP SAMPING --}}
                                        <div
                                            class="pointer-events-none absolute left-full top-1/2 z-50 ml-2 hidden -translate-y-1/2 rounded-xl bg-[#17181C] px-3 py-2 shadow-xl group-hover:block group-focus:block"
                                        >
                                            <p class="whitespace-nowrap text-[10px] font-medium text-gray-400">
                                                {{ $item['bulan'] }}
                                            </p>

                                            <p class="mt-1 whitespace-nowrap text-xs font-bold text-white">
                                                {{ number_format($item['total'], 0, ',', '.') }} Pesanan
                                            </p>
                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        </div>

                        {{-- LABEL BULAN --}}
                        <div class="mt-3 flex justify-between gap-3 px-2">
                            @foreach ($chartData as $item)
                                <div class="flex flex-1 justify-center">
                                    <span class="whitespace-nowrap text-[10px] font-medium text-gray-400">
                                        {{ $item['bulan'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <p class="mt-2 text-center text-[10px] text-gray-400">
                            Bulan 1 – Bulan 12
                        </p>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                    <p class="text-[11px] text-gray-400">
                        Data berdasarkan tanggal pembuatan pesanan.
                    </p>

                    <div class="flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                        <span class="text-[10px] font-medium text-gray-500">
                            Data terbaru
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layout.layout>
