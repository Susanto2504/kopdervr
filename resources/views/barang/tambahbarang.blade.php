<x-layout.layout :title="$title">
    {{-- HEADER --}}
    <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Tambah Barang</h1>
            <p class="mt-1 text-xs text-gray-400">Tambahkan barang baru ke katalog dan kelola stok.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="/stokbarang" class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-xs font-semibold text-gray-600 transition hover:bg-gray-50">Batal</a>
            <button type="submit" form="formTambahBarang" class="rounded-lg bg-[#DF301C] px-5 py-2.5 text-xs font-semibold text-white transition hover:bg-[#c92717]">Simpan barang</button>
        </div>
    </div>

    {{-- BREADCRUMB --}}
    <div class="mt-4 flex items-center gap-2 text-xs">
        <a href="#" class="text-gray-400 transition hover:text-gray-600">Barang & Stok</a>
        <span class="text-gray-300">/</span>
        <span class="font-semibold text-[#DF301C]">Tambah Barang</span>
    </div>

    {{-- FORM --}}
    <form id="formTambahBarang" action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            {{-- LEFT CONTENT --}}
            <div class="space-y-4 xl:col-span-2">
                {{-- INFORMASI BARANG --}}
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <div class="border-b border-gray-200 pb-3">
                        <h2 class="text-sm font-semibold text-gray-800">Informasi barang</h2>
                        <p class="mt-1 text-xs text-gray-400">Lengkapi identitas barang yang akan ditampilkan di katalog.</p>
                    </div>

                    {{-- NAMA BARANG --}}
                    <div class="mt-4">
                        <label class="mb-2 block text-xs font-semibold text-gray-700">Nama barang <span class="text-[#DF301C]">*</span></label>

                        <input type="text" name="nama" placeholder="Contoh: Cheetos Barbeque 72g" class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">
                    </div>

                    {{-- SKU & BARCODE --}}
                    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-gray-700">SKU <span class="text-[#DF301C]">*</span></label>

                            <input type="text" name="sku" placeholder="Contoh: SKU-CHT-BBQ" class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-semibold text-gray-700">Barcode</label>

                            <input type="text" name="barcode" placeholder="Masukkan nomor barcode" class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">
                        </div>
                    </div>

                    {{-- KATEGORI & SATUAN --}}
                    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-gray-700">Kategori <span class="text-[#DF301C]">*</span></label>

                            <div class="relative">
                                <select name="kategori_id" class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 pr-9 text-xs text-gray-500 outline-none transition focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">
                                    <option value="">Pilih kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                <svg class="pointer-events-none absolute right-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M6 9L12 15L18 9"/></svg>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-semibold text-gray-700">Satuan<span class="text-[#DF301C]">*</span></label>

                            <div class="relative">
                                <select name="satuan" class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 pr-9 text-xs text-gray-500 outline-none transition focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">
                                    <option value="">Pilih satuan</option>
                                    <option value="unit">Unit</option>
                                    <option value="pcs">Pcs</option>
                                    <option value="botol">Botol</option>
                                    <option value="pack">Pack</option>
                                    <option value="dus">Dus</option>
                                </select>

                                <svg class="pointer-events-none absolute right-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M6 9L12 15L18 9"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mt-4">
                        <label class="mb-2 block text-xs font-semibold text-gray-700">Deskripsi barang</label>
                        <div class="relative">
                            <textarea name="deskripsi" maxlength="300" rows="3" placeholder="Tulis deskripsi singkat barang..." class="w-full resize-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]"></textarea>
                            <span class="absolute bottom-2 right-3 text-[10px] text-gray-400">0/300</span>
                        </div>
                    </div>
                </div>

                {{-- HARGA & STOK --}}
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <div class="border-b border-gray-200 pb-3">
                        <h2 class="text-sm font-semibold text-gray-800">Harga & stok</h2>
                        <p class="mt-1 text-xs text-gray-400">Atur harga jual dan jumlah persediaan awal.</p>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                        {{-- HARGA MODAL --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-gray-700">Harga modal\<span class="text-[#DF301C]">*</span></label>

                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Rp</span>
                                <input type="number" name="harga_modal" min="0" placeholder="0" class="w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-9 pr-3 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]"
                                >
                            </div>
                        </div>

                        {{-- HARGA JUAL --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-gray-700">Harga jual<span class="text-[#DF301C]">*</span></label>

                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Rp</span>
                                <input type="number" name="harga_jual" min="0" placeholder="0" class="w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-9 pr-3 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">
                            </div>
                        </div>

                        {{-- STOK AWAL --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-gray-700">Stok awal <span class="text-[#DF301C]">*</span></label>
                            <input type="number" name="stok" min="0" placeholder="0 unit" class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">
                        </div>

                        {{-- BATAS STOK --}}
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-gray-700">Batas stok minimum</label>
                            <input type="number" name="batas_stok_minimum" min="0" placeholder="Contoh: 10 unit" class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#DF301C] focus:ring-1 focus:ring-[#DF301C]">
                        </div>
                    </div>

                    <p class="mt-3 text-[10px] text-gray-400">* Wajib diisi sebelum barang disimpan.</p>
                </div>
            </div>
        </div>
    </form>
</x-layout.layout>