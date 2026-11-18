<header class="flex h-20 items-center justify-between border-b border-gray-200 bg-white px-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">{{ $title }}</h2>
        <p class="mt-1 text-xs text-gray-400">Ringkasan operasional toko hari ini</p>
    </div>

    <div class="flex items-center gap-4">
        {{-- Profile --}}
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#FFF1D1]">
                <span class="text-xs font-semibold uppercase text-[#FF9100]">
                    {{ strtoupper(substr(session('pengguna_nama', 'Admin'), 0, 2)) }}
                </span>
            </div>

            <div class="hidden sm:block">
                <p class="text-xs font-semibold text-gray-800">
                    {{ session('pengguna_nama', 'Administrator') }}
                </p>
                <p class="text-xs text-gray-400">
                    {{ session('pengguna_peran', 'Admin') }}
                </p>
            </div>
        </div>
    </div>
</header>