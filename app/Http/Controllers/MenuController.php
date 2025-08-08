<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function __construct()
    {
        // Remove authorizeResource from constructor
        // $this->authorizeResource(Menu::class, 'menu');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Menu::class);

        $user = Auth::user();
        $query = Menu::query()->orderBy('created_at', 'desc');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $banners = Banner::all();

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
    {
        $this->authorize('create', Menu::class);

        $user = Auth::user();
        if ($user->role !== 'admin') {
            $banners = $user->banners; // Get banners owned by the current user
        } else {
            $banners = Banner::all();
        }
        return view('menu.create', compact('banners'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Menu::class);

        $user = Auth::user();

        $rules = [
            'nama'      => 'required|string|max:255',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'diskon'    => 'nullable|numeric',
            'kategori'  => 'required|string',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:3048',
        ];

        if ($user->role === 'admin') {
            $rules['banner_id'] = 'required|exists:banners,id';
        } else {
            // For non-admin, banner_id will be set automatically
            $rules['banner_id'] = 'nullable'; // Still allow it in validation but it will be overridden
        }

        $validated = $request->validate($rules);

        $menu            = new Menu();
        $menu->nama      = $validated['nama'];
        $menu->harga     = $validated['harga'];
        $menu->deskripsi = $validated['deskripsi'];
        $menu->stok      = $validated['stok'];
        $menu->diskon    = $validated['diskon'];
        $menu->kategori  = $validated['kategori'];
        $menu->user_id = $user->id;

        if ($user->role !== 'admin') {
            $userBanner = $user->banners()->first();
            if ($userBanner) {
                $menu->banner_id = $userBanner->id;
            } else {
                return redirect()->back()->withErrors(['banner' => 'Anda harus memiliki setidaknya satu banner untuk menambahkan menu.']);
            }
        } else {
            $menu->banner_id = $validated['banner_id'];
        }

        if ($request->hasFile('gambar')) {
            $menu->gambar = $request->file('gambar')->store('images', 'public');
        }

        $menu->save();
        return redirect()->route('menu.index', ['banner_id' => $menu->banner_id])
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $this->authorize('update', $menu);

        $banners = Banner::all();
        return view('menu.edit', compact('menu', 'banners'));
    }

    public function update(Request $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        $validated = $request->validate([
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
        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        $this->authorize('delete', $menu);

        if ($menu->gambar) {
            Storage::delete('public/' . $menu->gambar);
        }
        $menu->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    public function show(Request $request)
    {
        // No authorization needed for public view
        $query = Menu::query();
        $banners = Banner::all();
        $historyPesanan = collect(); // Default to an empty collection

        // Cek apakah ada parameter banner_id di URL
        if ($request->filled('banner_id')) {
            $selectedBanner = Banner::with('menus')->findOrFail($request->banner_id);
            $menu = $selectedBanner->menus()->get();
        } else {
            // If no specific banner_id, show all menus that belong to an existing banner
            $menu = $query->whereHas('banner')->get();
            $selectedBanner = null;
        }

        // Ambil riwayat pesanan jika meja_id ada
        if ($request->has('meja_id')) {
            $meja = \App\Models\meja::find($request->meja_id);
            if ($meja) {
                $historyPesanan = $meja->pesans()->with('menus')->latest()->get();
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'menu' => $menu,
                'selectedBanner' => $selectedBanner,
                'historyPesanan' => $historyPesanan,
            ]);
        }

        return view('menu', compact('menu', 'banners', 'selectedBanner', 'historyPesanan'));
    }
}
