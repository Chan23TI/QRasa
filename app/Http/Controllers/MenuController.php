<?php

namespace App\Http\Controllers;

use App\Models\menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $menu = Menu::orderBy('created_at', 'desc')->get(); //Menampilkan menu terbaru
    return view('menu.index', compact('menu'));
}

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'diskon' => 'nullable|numeric',
            'kategori' => 'required|numeric',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        $menu = new Menu();
        $menu->nama = $validated['nama'];
        $menu->harga = $validated['harga'];
        $menu->deskripsi = $validated['deskripsi'];
        $menu->stok = $validated['stok'];
        $menu->diskon = $validated['diskon'];
        $menu->kategori = $validated['kategori'];

        if ($request->hasFile('gambar')) {
            $menu->gambar = $request->file('gambar')->store('images', 'public');
        }

        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'diskon' => 'nullable|numeric',
            'kategori' => 'required|numeric',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        $menu->nama = $validated['nama'];
        $menu->harga = $validated['harga'];
        $menu->deskripsi = $validated['deskripsi'];
        $menu->stok = $validated['stok'];
        $menu->diskon = $validated['diskon'];
        $menu->kategori = $validated['kategori'];


        // Hapus elemen HTML yang tidak diinginkan dari deskripsi
        $menu->deskripsi = strip_tags($validated['deskripsi']);

        if ($request->hasFile('gambar')) {
            if ($menu->gambar) {
                Storage::delete('public/' . $menu->gambar);
            }
            $menu->gambar = $request->file('gambar')->store('images', 'public');
        }

        $menu->save();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }


    public function destroy(Menu $menu)
    {
        if ($menu->gambar) {
            Storage::delete('public/' . $menu->gambar);
        }

        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
