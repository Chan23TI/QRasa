<?php

namespace App\Http\Controllers;

use App\Models\ABC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ABCController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ABC = ABC::all();
        return view('ABC.index', compact('ABC'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ABC.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $ABC = new ABC();
        $ABC->judul = $request->judul;
        $ABC->isi = $request->isi;

        if ($request->hasFile('gambar')) {
            $ABC->gambar = $request->file('gambar')->store('images', 'public');
        }

        $ABC->save();

        return redirect()->route('ABC.index')->with('success', 'About berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ABC $ABC)
    {
        return view('ABC.show', compact('ABC'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ABC = ABC::findOrFail($id);
        return view('ABC.edit', compact('ABC'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $ABC = ABC::findOrFail($id);
        $ABC->judul = $request->judul;
        $ABC->isi = $request->isi;

        if ($request->hasFile('gambar')) {
            if ($ABC->gambar) {
                Storage::delete('public/' . $ABC->gambar);
            }
            $ABC->gambar = $request->file('gambar')->store('images', 'public');
        }

        $ABC->save();

        return redirect()->route('ABC.index')->with('success', 'About berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ABC = ABC::findOrFail($id);

        if ($ABC->gambar) {
            Storage::delete('public/' . $ABC->gambar);
        }

        $ABC->delete();

        return redirect()->route('ABC.index')->with('success', 'About berhasil dihapus.');
    }
}
