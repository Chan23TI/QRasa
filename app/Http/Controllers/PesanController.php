<?php
namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
// Import Throwable

class PesanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Tampilkan semua pesanan tanpa filter berdasarkan user
        $query = Pesan::with(['menus', 'meja', 'user']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        $pesans = $query->latest()->paginate(10);

        // Get unique statuses and payment methods for filter options
        $statuses = Pesan::distinct()->pluck('status')->toArray();
        $statuses = array_diff($statuses, ['sedang diproses', 'pending']);

        $paymentMethods = Pesan::distinct()->pluck('payment_method')->toArray();
        if (!in_array('QRIS', $paymentMethods)) {
            $paymentMethods[] = 'QRIS';
        }
        // Sort payment methods alphabetically for better UX
        sort($paymentMethods);

        // Batasi akses hanya untuk role admin, chef, waiter, dan cashier
        if (!in_array($user->role, ['admin', 'chef', 'waiter', 'cashier'])) {
            abort(403, 'Unauthorized action.');
        }else {
            return view('pesan.index', compact('pesans', 'statuses', 'paymentMethods'));
        }

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
        try {
            $request->validate([
                'cartItems'            => 'required|array',
                'cartItems.*.id'       => 'required|exists:menus,id',
                'cartItems.*.quantity' => 'required|integer|min:1',
                'total'                => 'required|numeric|min:0',
                'payment_method'       => 'required|string',
                'meja_id'              => 'nullable|exists:mejas,id',
            ]);

            $createdPesanIds = [];

            // Calculate total and prepare menu quantities for this single order
            $total          = 0;
            $menuQuantities = [];
            $menuIds        = collect($request->cartItems)->pluck('id')->unique()->all();
            $allMenus       = \App\Models\Menu::whereIn('id', $menuIds)->get()->keyBy('id');

            foreach ($request->cartItems as $item) {
                $menu = $allMenus->get($item['id']);
                if (! $menu) {
                    continue;
                }

                // Validasi stok
                if ($menu->stok <= 0) {
                    return response()->json(['success' => false, 'message' => "Stok untuk menu '{$menu->nama}' sudah habis."], 400);
                }
                if ($item['quantity'] > $menu->stok) {
                    return response()->json(['success' => false, 'message' => "Stok untuk menu '{$menu->nama}' tidak mencukupi."], 400);
                }

                $total += ($menu->harga * $item['quantity']);
                $menuQuantities[$item['id']] = ['quantity' => $item['quantity']];

                // Kurangi stok menu
                $menu->stok -= $item['quantity'];
                $menu->save();
            }

            // Create the Pesan entry
            $pesan                    = new Pesan();
            $pesan->meja_id           = $request->meja_id;
            $pesan->total             = $total;
            $pesan->status            = 'belum diantar';
            $pesan->status_pembayaran = 'belum dibayar';
            $pesan->payment_method    = $request->payment_method;
            $pesan->save();

            $pesan->menus()->attach($menuQuantities);
            $createdPesanIds[] = $pesan->id;

            if ($request->ajax()) {
                return response()->json([
                    'success'           => true,
                    'message'           => 'Pesanan berhasil dibuat!',
                    'redirect'          => route('pesan.summary', ['pesan' => $pesan->id]),
                    'created_pesan_ids' => $createdPesanIds,
                ]);
            }

            // For non-AJAX requests, redirect to the index page to see all orders
            return redirect()->route('pesan.index')->with('success', 'Pesanan berhasil dibuat!');
        } catch (Throwable $e) {
            // Log the error for debugging
            \Log::error('Checkout Error: ' . $e->getMessage(), [
                'file'         => $e->getFile(),
                'line'         => $e->getLine(),
                'trace'        => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            // Return a JSON error response
            if ($request->ajax()) {
                return response()->json([
                    'success'       => false,
                    'message'       => 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage(),
                    'error_details' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ],
                ], 500);
            }

            // For non-AJAX requests, redirect back with error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Pesan $pesan)
    {
        $pesan->load(['menus', 'meja']);
        return view('pesan.summary', compact('pesan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesan $pesan)
    {
        //
    }

    public function updateStatus(Pesan $pesan)
    {
        $user = auth()->user();

        // Batasi akses hanya untuk role admin, chef, waiter, dan cashier
        if (! in_array($user->role, ['admin', 'chef', 'waiter', 'cashier'])) {
            abort(403, 'Unauthorized action.');
        }

        $pesan->update(['status' => 'sudah diantar']);
        return redirect()->route('pesan.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // Tambahan baru
    public function updateStatusPembayaran(Pesan $pesan)
    {
        $user = auth()->user();

        // Batasi akses hanya untuk role admin, chef, waiter, dan cashier
        if (! in_array($user->role, ['admin', 'chef', 'waiter', 'cashier'])) {
            abort(403, 'Unauthorized action.');
        }

        $pesan->update(['status_pembayaran' => 'sudah dibayar']);
        return redirect()->route('pesan.index')->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesan $pesan)
    {
        //
    }
}
