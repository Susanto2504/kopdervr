<?php

namespace App\Http\Controllers\barang;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        // SEARCH NAMA DAN SKU
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // FILTER KATEGORI
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // PAGINATION
        $barang = $query->latest()->paginate(10)->withQueryString();

        // AMBIL DATA KATEGORI
        $kategoris = Kategori::all();

        return view('barang.barang', [
            'title' => 'Daftar Barang',
            'barang' => $barang,
            'kategoris' => $kategoris
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('barang.tambahbarang', ['title' => 'Stok & Barang', 'kategoris' => $kategoris]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'                 => 'required|string|max:255',
            'sku'                  => 'required|string|max:255|unique:barangs,sku',
            'barcode'              => 'nullable|string|max:255|unique:barangs,barcode',
            'kategori_id'          => 'required|exists:kategoris,id',
            'satuan'               => 'required|string|max:255',
            'deskripsi'            => 'nullable|string|max:300',
            'harga_modal'          => 'required|numeric|min:0',
            'harga_jual'           => 'required|numeric|min:0',
            'stok'                 => 'required|integer|min:0',
            'batas_stok_minimum'   => 'nullable|integer|min:0',
            'foto'                 => 'nullable|image|max:2048',
            'status'               => 'nullable|in:aktif,nonaktif',
        ]);

        // Ambil ID pengguna yang sedang login
        $validated['dibuat_oleh'] = 1;

        // Nilai default jika status tidak dikirim
        $validated['status'] = $request->input('status', 'aktif');

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('barang', 'public');
        }

        // Simpan ke database
        Barang::create($validated);
        return redirect('/stokbarang')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($nama)
    {
        $barang = Barang::where('nama', $nama)->firstOrFail();

        return view('barang.detailbarang', [
            'title' => 'Detail Barang',
            'barang' => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nama)
    {
        $barang = Barang::where('nama', $nama)->firstOrFail();
        $kategoris = Kategori::all();

        return view('barang.editbarang', [
            'title' => 'Edit Barang',
            'barang' => $barang,
            'kategoris' => $kategoris
        ]);
    }

    public function update(Request $request, $nama)
    {
        $barang = Barang::where('nama', $nama)->firstOrFail();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'sku' => 'required|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'kategori_id' => 'required',
            'satuan' => 'required|string',
            'deskripsi' => 'nullable|string|max:300',
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'batas_stok_minimum' => 'nullable|integer|min:0',
            'status' => 'nullable|in:aktif',
        ]);

        $validated['status'] = $request->has('status') ? 'aktif' : 'nonaktif';

        $barang->update($validated);

        return redirect('/stokbarang')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}
