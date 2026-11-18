
<x-layout.layout :title="$title">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Detail Barang</h1>
            <p class="mt-1 text-xs text-gray-400">
                Informasi lengkap mengenai barang yang tersimpan dalam katalog.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="/stokbarang"
                class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-xs font-semibold text-gray-600 transition hover:bg-gray-50">
                Kembali
            </a>

            <a href="/stokbarang/{{ $barang->nama }}/edit"
                class="rounded-lg bg-[#DF301C] px-5 py-2.5 text-xs font-semibold text-white transition hover:bg-[#c92717]">
                Edit barang
            </a>
        </div>
    </div>

    {{-- BREADCRUMB --}}
    <div class="mt-4 flex items-center gap-2 text-xs">
        <a href="/stokbarang" class="text-gray-400 transition hover:text-gray-600">
            Barang & Stok
        </a>
        <span class="text-gray-300">/</span>
        <span class="font-semibold text-[#DF301C]">Detail Barang</span>
    </div>

    <div class="mt-4 grid grid-cols-1 gap-4 xl:grid-cols-3">

        {{-- LEFT CONTENT --}}
        <div class="space-y-4 xl:col-span-2">

            {{-- INFORMASI BARANG --}}
            <div class="rounded-xl border border-gray-200 bg-white p-4">
                <div class="border-b border-gray-200 pb-3">
                    <h2 class="text-sm font-semibold text-gray-800">Informasi barang</h2>
                    <p class="mt-1 text-xs text-gray-400">
                        Identitas dan informasi dasar barang.
                    </p>
                </div>

                {{-- NAMA BARANG --}}
                <div class="mt-4">
                    <label class="mb-2 block text-xs font-semibold text-gray-500">
                        Nama barang
                    </label>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs text-gray-700">
                        {{ $barang->nama }}
                    </div>
                </div>

                {{-- SKU & BARCODE --}}
                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-xs font-semibold text-gray-500">SKU</label>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs text-gray-700">
                            {{ $barang->sku ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-semibold text-gray-500">Barcode</label>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs text-gray-700">
                            {{ $barang->barcode ?? '-' }}
                        </div>
                    </div>
                </div>

                {{-- KATEGORI & SATUAN --}}
                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-xs font-semibold text-gray-500">Kategori ID</label>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs text-gray-700">
                                {{ $barang->kategori->nama ?? '-' }}
                            </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-semibold text-gray-500">Satuan</label>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs text-gray-700">
                            {{ $barang->satuan ?? '-' }}
                        </div>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mt-4">
                    <label class="mb-2 block text-xs font-semibold text-gray-500">
                        Deskripsi barang
                    </label>
                    <div class="min-h-20 rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs leading-relaxed text-gray-700">
                        {{ $barang->deskripsi ?: 'Tidak ada deskripsi barang.' }}
                    </div>
                </div>
            </div>

            {{-- HARGA & STOK --}}
            <div class="rounded-xl border border-gray-200 bg-white p-4">
                <div class="border-b border-gray-200 pb-3">
                    <h2 class="text-sm font-semibold text-gray-800">Harga & stok</h2>
                    <p class="mt-1 text-xs text-gray-400">
                        Informasi harga dan jumlah persediaan barang.
                    </p>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">

                    {{-- HARGA MODAL --}}
                    <div>
                        <label class="mb-2 block text-xs font-semibold text-gray-500">
                            Harga modal
                        </label>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs text-gray-700">
                            Rp {{ number_format($barang->harga_modal, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- HARGA JUAL --}}
                    <div>
                        <label class="mb-2 block text-xs font-semibold text-gray-500">
                            Harga jual
                        </label>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs font-semibold text-gray-700">
                            Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- STOK --}}
                    <div>
                        <label class="mb-2 block text-xs font-semibold text-gray-500">
                            Stok tersedia
                        </label>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs text-gray-700">
                            {{ $barang->stok }} {{ $barang->satuan }}
                        </div>
                    </div>

                    {{-- BATAS STOK --}}
                    <div>
                        <label class="mb-2 block text-xs font-semibold text-gray-500">
                            Batas stok minimum
                        </label>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs text-gray-700">
                            {{ $barang->batas_stok_minimum ?? 0 }} {{ $barang->satuan }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT CONTENT --}}
        <div class="space-y-4">

            {{-- RINGKASAN BARANG --}}
            <div class="rounded-xl border border-gray-200 bg-white p-4">
                <div class="border-b border-gray-200 pb-3">
                    <h2 class="text-sm font-semibold text-gray-800">Ringkasan barang</h2>
                    <p class="mt-1 text-xs text-gray-400">
                        Ringkasan informasi persediaan.
                    </p>
                </div>

                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">Nama barang</span>
                        <span class="max-w-36 truncate text-xs font-medium text-gray-700">
                            {{ $barang->nama }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">SKU</span>
                        <span class="text-xs font-medium text-gray-700">
                            {{ $barang->sku ?? '-' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">Stok</span>
                        <span class="text-xs font-semibold text-gray-700">
                            {{ $barang->stok }} {{ $barang->satuan }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">Harga jual</span>
                        <span class="text-xs font-semibold text-[#DF301C]">
                            Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-layout.layout>
