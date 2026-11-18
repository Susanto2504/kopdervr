<div class="sticky top-0 flex min-h-screen flex-col">
    {{-- LOGO --}}
    <div class="flex h-20 items-center px-5">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#DF301C]">
            <span class="text-xs font-bold">VR</span>
        </div>

        <div class="ml-3">
            <h1 class="text-sm font-bold">KOPDES</h1>
            <p class="text-xs text-gray-400">Koperasi Desa Berbasis VR</p>
        </div>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 px-3">
        <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Menu Utama</p>

        {{-- Dashboard --}}
        <x-layout.nav-link href="/" :active="request()->is('/')">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                <rect x="4" y="4" width="6" height="6" rx="1"/>
                <rect x="14" y="4" width="6" height="6" rx="1"/>
                <rect x="4" y="14" width="6" height="6" rx="1"/>
                <rect x="14" y="14" width="6" height="6" rx="1"/>
            </svg>
            Dashboard
        </x-layout.nav-link>

        {{-- Barang --}}
        <x-layout.nav-link href="/stokbarang" :active="request()->is('stokbarang')">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                <path d="M21 8.5L12 4 3 8.5V15.5L12 20L21 15.5V8.5Z"/>
                <path d="M3 8.5L12 13L21 8.5"/>
                <path d="M12 13V20"/>
            </svg>
            Barang & Stok

        </x-layout.nav-link>

        {{-- Pemesanan --}}
        <x-layout.nav-link href="/datapesanan" :active="request()->is('datapesanan')">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                <rect x="5" y="4" width="14" height="16" rx="2"/>
                <path d="M9 4V2H15V4"/>
                <path d="M8 9H16"/>
                <path d="M8 13H16"/>
                <path d="M8 17H13"/>
            </svg>
            Data Pemesanan
        </x-layout.nav-link>

        {{-- Riwayat --}}
        <x-layout.nav-link href="/riwayatpesanan" :active="request()->is('riwayatpesanan')">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                <path d="M3 12A9 9 0 1 0 6 5.5"/>
                <path d="M3 4V9H8"/>
                <path d="M12 7V12L15 14"/>
            </svg>
            Riwayat Pesanan
        </x-layout.nav-link>
    </nav>

    {{-- LOGOUT --}}
    <div class="px-3 pb-5">
        <form action="{{ route('logout') }}" method="POST"
            onsubmit="return confirm('Apakah kamu yakin ingin keluar?')">
            @csrf

            <button type="submit"
                class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-red-400 transition hover:bg-red-500/10 hover:text-red-500">

                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                    stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10 12h11m0 0-4-4m4 4-4 4"/>
                </svg>

                Keluar
            </button>
        </form>
    </div>
</div>