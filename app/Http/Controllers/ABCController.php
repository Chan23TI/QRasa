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
            'isi' => 'required|string',
            'gambar1' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'gambar2' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $ABC = new ABC();
        $ABC->isi = $request->isi;
        $ABC->gambar1 = $request->gambar1;
        $ABC->gambar2 = $request->gambar2;

        if ($request->hasFile('gambar1')) {
            $ABC->gambar1 = $request->file('gambar1')->store('images', 'public');
        }
        if ($request->hasFile('gambar2')) {
            $ABC->gambar2 = $request->file('gambar2')->store('images', 'public');
        }

        $ABC->save();
        return redirect()->route('ABC.index')->with('success', 'About berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(ABC $aBC)
    {
        //
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
    public function update(Request $request,  $id)
{
    $request->validate([
        'isi' => 'string|required',
        'gambar1' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'gambar2' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $ABC = ABC::findOrFail($id);

    if ($request->hasFile('gambar1')) {
        if ($ABC->gambar1) {
            Storage::delete('public/' . $ABC->gambar1);
        }
        $ABC->gambar1 = $request->file('gambar1')->store('images', 'public');
    }

    if ($request->hasFile('gambar2')) {
        if ($ABC->gambar2) {
            Storage::delete('public/' . $ABC->gambar2);
        }
        $ABC->gambar2 = $request->file('gambar2')->store('images', 'public');
    }

    $ABC->isi = $request->isi;
    $ABC->save();

    return redirect()->route('ABC.index')->with('success', 'About berhasil diupdate.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ABC = ABC::findOrFail($id);
        if ($ABC->gambar1) {
            Storage::delete('public/' . $ABC->gambar1);
        }

        if ($ABC->gambar2) {
            Storage::delete('public/' . $ABC->gambar2);
        }
        $ABC->delete();
        return redirect()->route('ABC.index')->with('success', 'About berhasil dihapus.');

    }
}
