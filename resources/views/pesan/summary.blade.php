<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        <x-admin-sidebar />

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Ringkasan Pesanan</h1>
                <p class="text-gray-600 mt-1">Detail pesanan Anda.</p>
            </div>

            @if (session('success'))
                <div class="mb-8 bg-green-100 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm overflow-hidden p-6">
                <h2 class="text-xl font-semibold mb-4">Detail Pesanan #{{ $pesan->id }}</h2>
                <div class="mb-4">
                    <p><strong>Status:</strong> <span class="capitalize">{{ $pesan->status }}</span></p>
                    <p><strong>Metode Pembayaran:</strong> <span class="capitalize">{{ $pesan->payment_method }}</span></p>
                    <p><strong>Tanggal Pesan:</strong> {{ $pesan->created_at->format('d M Y H:i') }}</p>
                </div>

                <h3 class="text-lg font-semibold mb-3">Item Pesanan:</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pesan->menus as $menu)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $menu->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($menu->harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $menu->pivot->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($menu->harga * $menu->pivot->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Keseluruhan:</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Rp{{ number_format($pesan->total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-6 text-right">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-hijau1 text-white rounded-lg hover:bg-hijau1/90 transition-colors duration-150">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
