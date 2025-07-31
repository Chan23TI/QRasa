<?php

namespace App\Http\Controllers;

use App\Models\pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'cartItems' => 'required|array',
            'cartItems.*.id' => 'required|exists:menus,id',
            'cartItems.*.quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        $user = auth()->user();

        $pesan = new Pesan();
        $pesan->user_id = $user->id;
        $pesan->total = $request->total;
        $pesan->status = 'pending'; // Atau status awal lainnya
        $pesan->payment_method = $request->payment_method;
        $pesan->save();

        $menuQuantities = [];
        foreach ($request->cartItems as $item) {
            $menuQuantities[$item['id']] = ['quantity' => $item['quantity']];

            // Kurangi stok menu
            $menu = \App\Models\Menu::find($item['id']);
            if ($menu) {
                $menu->stok -= $item['quantity'];
                $menu->save();
            }
        }
        $pesan->menus()->attach($menuQuantities);

        return redirect()->route('pesan.summary', $pesan->id)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show(pesan $pesan)
    {
        return view('pesan.summary', compact('pesan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pesan $pesan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pesan $pesan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pesan $pesan)
    {
        //
    }
}
