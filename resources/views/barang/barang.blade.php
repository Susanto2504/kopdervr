
<x-layout.layout :title="$title">

    {{-- HEADER & SEARCH --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        {{-- SEARCH --}}
        <form action="{{ url()->current() }}" method="GET"
            class="relative w-full lg:w-72">

            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7"/>
                <path d="M20 20L16 16"/>
            </svg>

            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama barang atau SKU..."
                class="w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-9 pr-16 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">

            @if(request('search'))
                <a href="{{ url()->current() }}?{{ http_build_query(request()->except(['search', 'page'])) }}"
                    title="Hapus pencarian"
                    class="absolute right-10 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500">
                    <i class="fi fi-br-cross text-xs"></i>
                </a>
            @endif

            <button type="submit"
                title="Cari barang"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#DF301C]">
                <i class="fi fi-br-search text-sm"></i>
            </button>

            {{-- PERTAHANKAN FILTER KATEGORI --}}
            @if(request('kategori_id'))
                <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
            @endif

        </form>

        {{-- BUTTON TAMBAH --}}
        <div class="flex items-center gap-2">
            <a href="/stokbarang/tambahbarang"
                class="rounded-lg bg-[#DF301C] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#c92717]">
                Tambah barang
            </a>
        </div>

    </div>

    
    {{-- FILTER KATEGORI --}}
    <div class="mt-4 flex flex-wrap gap-2">

        <form action="{{ url()->current() }}" method="GET">

            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="relative">
                <select name="kategori_id"
                    onchange="this.form.submit()"
                    class="appearance-none rounded-lg border border-gray-200 bg-white py-2 pl-3 pr-9 text-xs text-gray-600 outline-none transition focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">

                    <option value="">Semua kategori</option>

                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach

                </select>

                <svg class="pointer-events-none absolute right-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-gray-400"
                    fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path d="M6 9L12 15L18 9"/>
                </svg>
            </div>

        </form>

    </div>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-xs font-medium text-green-600">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if(session('error'))
        <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-xs font-medium text-red-600">
            {{ session('error') }}
        </div>
    @endif

    {{-- TABLE CONTAINER --}}
    <div class="mt-4 overflow-hidden rounded-xl border border-gray-200 bg-white">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px]">

                {{-- HEADER TABLE --}}
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">

                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Barang
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            SKU
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Stok
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Harga
                        </th>

                        {{-- KATEGORI --}}
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Kategori
                        </th>

                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Aksi
                        </th>

                    </tr>
                </thead>

                {{-- BODY TABLE --}}
                <tbody>

                    @forelse ($barang as $baran)

                        <tr class="border-b border-gray-100 transition hover:bg-gray-50">

                            {{-- NAMA BARANG --}}
                            <td class="px-4 py-3">
                                <span class="text-xs font-medium text-gray-700">
                                    {{ $baran->nama }}
                                </span>
                            </td>

                            {{-- SKU --}}
                            <td class="px-4 py-3 text-xs text-gray-400">
                                {{ $baran->sku }}
                            </td>

                            {{-- STOK --}}
                            <td class="px-4 py-3 text-xs text-gray-700">
                                {{ $baran->stok }}
                            </td>

                            {{-- HARGA --}}
                            <td class="px-4 py-3 text-xs text-gray-700">
                                Rp {{ number_format($baran->harga_jual, 0, ',', '.') }}
                            </td>
    
                            {{-- KATEGORI --}}
                            <td class="px-4 py-3">
                                @if ($baran->kategori)
                                    <span class="rounded-full bg-orange-50 px-2.5 py-1 text-xs font-medium text-orange-600">
                                        {{ $baran->kategori->nama }}
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">
                                        Tidak diketahui
                                    </span>
                                @endif
                            </td>

                            {{-- ACTION --}}
                            <td class="px-4 py-3">

                                <div class="flex items-center justify-end gap-3">

                                    {{-- DETAIL --}}
                                    <a href="{{ route('barang.show', ['nama' => $baran->nama]) }}"
                                        title="Detail"
                                        class="text-blue-500 transition hover:text-blue-700">
                                        <i class="fi fi-br-eye"></i>
                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('barang.edit', ['nama' => $baran->nama]) }}"
                                        title="Edit"
                                        class="text-yellow-500 transition hover:text-yellow-700">
                                        <i class="fi fi-br-pencil"></i>
                                    </a>

                                    {{-- HAPUS --}}
                                    <form action="{{ route('barang.destroy', $baran->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            title="Hapus"
                                            class="text-red-500 transition hover:text-red-700">
                                            <i class="fi fi-br-trash"></i>
                                        </button>

                                    </form>
                                </div>

                            </td>

                        </tr>

                    @empty

                        {{-- EMPTY DATA --}}
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">

                                <div class="flex flex-col items-center">

                                    <i class="fi fi-br-box-open text-3xl text-gray-300"></i>

                                    <p class="mt-3 text-xs font-semibold text-gray-600">
                                        Data barang tidak ditemukan
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        Coba gunakan pencarian atau kategori lainnya.
                                    </p>

                                    <a href="{{ url()->current() }}"
                                        class="mt-3 text-xs font-semibold text-[#DF301C] hover:underline">
                                        Reset filter
                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="flex flex-col gap-3 border-t border-gray-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

            {{-- JUMLAH DATA --}}
            <p class="text-xs text-gray-400">

                Menampilkan

                <span class="font-semibold text-gray-700">
                    {{ $barang->firstItem() ?? 0 }}-{{ $barang->lastItem() ?? 0 }}
                </span>

                dari

                <span class="font-semibold text-gray-700">
                    {{ $barang->total() }}
                </span>

                barang

            </p>

            {{-- NAVIGATION --}}
            <div class="flex items-center gap-1">

                {{-- PREVIOUS --}}
                @if ($barang->onFirstPage())

                    <span class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-lg border border-gray-200 text-gray-300">
                        <i class="fi fi-br-angle-left text-xs"></i>
                    </span>

                @else

                    <a href="{{ $barang->previousPageUrl() }}"
                        class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:border-[#DF301C] hover:text-[#DF301C]">
                        <i class="fi fi-br-angle-left text-xs"></i>
                    </a>

                @endif

                {{-- PAGE NUMBERS --}}
                @foreach ($barang->getUrlRange(1, $barang->lastPage()) as $page => $url)

                    @if ($page == $barang->currentPage())

                        <span class="flex h-8 min-w-8 items-center justify-center rounded-lg bg-[#DF301C] px-2 text-xs font-semibold text-white">
                            {{ $page }}
                        </span>

                    @else

                        <a href="{{ $url }}"
                            class="flex h-8 min-w-8 items-center justify-center rounded-lg border border-gray-200 px-2 text-xs text-gray-500 transition hover:border-[#DF301C] hover:text-[#DF301C]">
                            {{ $page }}
                        </a>

                    @endif

                @endforeach

                {{-- NEXT --}}
                @if ($barang->hasMorePages())

                    <a href="{{ $barang->nextPageUrl() }}"
                        class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:border-[#DF301C] hover:text-[#DF301C]">
                        <i class="fi fi-br-angle-right text-xs"></i>
                    </a>

                @else

                    <span class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-lg border border-gray-200 text-gray-300">
                        <i class="fi fi-br-angle-right text-xs"></i>
                    </span>

                @endif

            </div>

        </div>

    </div>

</x-layout.layout>
