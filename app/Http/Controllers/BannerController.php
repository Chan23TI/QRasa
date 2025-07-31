<?php

namespace App\Http\Controllers;

use App\Models\banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Banner::class, 'banner');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Banner::query()->latest();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $banners = $query->paginate(5);

        return view('banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:3048',
        ]);

        $banner = new Banner();
        $banner->nama = $validated['nama'];
        $banner->user_id = Auth::id();

        if ($request->hasFile('gambar')) {
            $banner->gambar = $request->file('gambar')->store('images', 'public');
        }

        $banner->save();

        return redirect()->route('banner.index')->with('success', 'Banner berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner) // Changed from $id to Banner $banner
    {
        return view('banner.edit', compact('banner')); // Changed from banners to banner
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, banner $banner)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:3048',
        ]);

        $banner->nama = $validated['nama'];

        if ($request->hasFile('gambar')) {
            if ($banner->gambar) {
                Storage::delete('public/' . $banner->gambar);
            }
            $banner->gambar = $request->file('gambar')->store('images', 'public');
        }

        $banner->save();
        return redirect()->route('banner.index')->with('success', 'Banner berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(banner $banner)
    {
        if ($banner->gambar) {
            Storage::delete('public/' . $banner->gambar);
        }

        $banner->delete();
        return redirect()->route('banner.index')->with('success', ' Banner berhasil dihapus!');
    }
}
