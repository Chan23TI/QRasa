{{-- pesan/summary.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Pesanan - QRasa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('img/Logo/LogoKantin.png') }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        hijau1: "#3f7d58",
                        hijau2: "#537d5d",
                        oren: "#ef9651",
                        orenTua: "#ec5228",
                        putih: "#efefef",
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-hijau1 shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-center h-16">
                <div class="flex items-center">
                    <img src="{{ asset('img/Logo/LogoKantin.png') }}" alt="Logo QRasa"
                        class="w-10 h-10 rounded-full mr-3 object-cover">
                    <h1 class="text-putih text-xl font-bold">QRasa</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-green-600 text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-green-600">Pesanan Berhasil!</h1>
                    <p class="text-gray-600">Terima kasih atas pesanan Anda</p>
                </div>

                <div class="border-b pb-4 mb-4">
                    <h2 class="text-lg font-semibold mb-3">Detail Pesanan</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Pesanan:</span>
                            <span class="font-medium">#{{ $pesan->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kantin:</span>
                            <span class="font-medium">{{ $pesan->banner ? $pesan->banner->nama : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Meja:</span>
                            <span class="font-medium">{{ $pesan->meja ? $pesan->meja->nomor_meja : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $pesan->status === 'sedang diproses' ? 'bg-orange-100 text-orenTua'  : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($pesan->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode Pembayaran:</span>
                            <span class="font-medium">{{ ucfirst($pesan->payment_method) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Waktu Pesan:</span>
                            <span class="font-medium">{{ $pesan->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-semibold mb-3">Item Pesanan</h3>
                    <div class="space-y-3">
                        @foreach ($pesan->menus as $menu)
                            <div class="flex justify-between items-start py-3 border-b last:border-b-0">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">{{ $menu->nama }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $menu->pivot->quantity }} x Rp
                                        {{ number_format($menu->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-800">
                                        Rp {{ number_format($menu->harga * $menu->pivot->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="border-t pt-4 mb-6">
                    <div class="flex justify-between items-center text-xl font-bold text-gray-800">
                        <span>Total Pembayaran:</span>
                        <span class="text-hijau1">Rp {{ number_format($pesan->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="text-center space-y-3">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            Pesanan Anda sedang diproses. Silakan menunggu konfirmasi dari penjual.
                        </p>
                    </div>

                    <a href="{{ route('menu.show') }}"
                        class="inline-flex items-center bg-hijau1 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Menu
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-hijau1 text-putih py-4 mt-8">
        <div class="container mx-auto text-center">
            <p class="text-sm font-semibold">© {{ date('Y') }} QRasa. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
