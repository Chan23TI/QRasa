<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $banners = Banner::all();
        $query = Menu::query()->orderBy('created_at', 'desc');

        // Filter berdasarkan banner_id jika ada
        if ($request->filled('banner_id')) {
            $query->where('banner_id', $request->banner_id);
            $selectedBanner = Banner::findOrFail($request->banner_id);
        } else {
            $selectedBanner = null;
        }

        // Menggunakan pagination
        $menu = $query->paginate(5);

        return view('menu.index', compact('menu', 'banners', 'selectedBanner'));
    }

    public function create()
    {$banners = Banner::all();
        return view('menu.create', compact('banners'));}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'diskon'    => 'nullable|numeric',
            'kategori'  => 'required|string',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:3048',
            'banner_id' => 'nullable|exists:banners,id',
        ]);

        $menu            = new Menu();
        $menu->nama      = $validated['nama'];
        $menu->harga     = $validated['harga'];
        $menu->deskripsi = $validated['deskripsi'];
        $menu->stok      = $validated['stok'];
        $menu->diskon    = $validated['diskon'];
        $menu->kategori  = $validated['kategori'];
        $menu->banner_id = $validated['banner_id'];

        if ($request->hasFile('gambar')) {
            $menu->gambar = $request->file('gambar')->store('images', 'public');
        }

        $menu->save();
        return redirect()->route('menu.index', ['banner_id' => $menu->banner_id])
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {$menu = Menu::findOrFail($id);
        $banners                         = Banner::all();
        return view('menu.edit', compact('menu', 'banners'));}

    public function update(Request $request, $id)
    {$menu = Menu::find($id);
        $validated                       = $request->validate([
            'nama'      => 'required|string|max:255',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'diskon'    => 'nullable|numeric',
            'kategori'  => 'required|string',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:3048',
        ]);

        $menu->nama  = $validated['nama'];
        $menu->harga = $validated['harga'];
        // Remove unwanted HTML from the description
        $menu->deskripsi = strip_tags($validated['deskripsi']);
        $menu->stok      = $validated['stok'];
        $menu->diskon    = $validated['diskon'];
        $menu->kategori  = $validated['kategori'];

        if ($request->hasFile('gambar')) {
            if ($menu->gambar) {
                Storage::delete('public/' . $menu->gambar);
            }
            $menu->gambar = $request->file('gambar')->store('images', 'public');
        }

        $menu->save();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');}
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if ($menu->gambar) {
            Storage::delete('public/' . $menu->gambar);
        }
        if ($menu) {
            $menu->delete();
            return redirect()->back()->with('success', 'Menu berhasil dihapus!');
        }
        return redirect()->back()->with('error', 'Menu tidak ditemukan');
    }

    public function show(Request $request)
    {
        $banners = Banner::all();

        // Cek apakah ada parameter banner_id di URL
        if ($request->filled('banner_id')) {
            $selectedBanner = Banner::with('menus')->findOrFail($request->banner_id);
            $menu           = $selectedBanner->menus;
        } else {
            $menu           = Menu::all();
            $selectedBanner = null;
        }
        return view('menu', compact('menu', 'banners', 'selectedBanner'));
    }
}
