{{-- pesan/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan - QRasa</title>
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
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('img/Logo/LogoKantin.png') }}" alt="Logo QRasa"
                        class="w-10 h-10 rounded-full mr-3 object-cover">
                    <h1 class="text-putih text-xl font-bold">QRasa</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('menu.show') }}"
                       class="text-putih hover:text-gray-200 transition-colors">
                        <i class="fas fa-home mr-2"></i>Menu
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-8">
        <div class="container mx-auto px-4">
            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Ringkasan Pesanan Anda</h1>
                <p class="text-gray-600">Detail semua pesanan Anda yang baru saja dibuat</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="max-w-4xl mx-auto mb-8">
                    <div class="bg-green-100 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-green-800 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Content -->
            <div class="max-w-6xl mx-auto">
                @if ($pesans->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-receipt text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Pesanan</h3>
                        <p class="text-gray-600 mb-6">Anda belum memiliki pesanan apapun</p>
                        <a href="{{ route('menu.show') }}"
                           class="inline-flex items-center bg-hijau1 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                            <i class="fas fa-utensils mr-2"></i>
                            Mulai Pesan Sekarang
                        </a>
                    </div>
                @else
                    <!-- Orders List -->
                    <div class="space-y-8">
                        @foreach ($pesans as $pesan)
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                <!-- Order Header -->
                                <div class="bg-gray-50 px-6 py-4 border-b">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                        <div>
                                            <h2 class="text-xl font-semibold text-gray-800 mb-1">
                                                Pesanan #{{ $pesan->id }}
                                                @if ($pesan->banner)
                                                    <span class="text-base text-gray-500 font-normal">({{ $pesan->banner->nama }})</span>
                                                @endif
                                            </h2>
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                                <span><i class="fas fa-table mr-1"></i>Meja: {{ $pesan->meja ? $pesan->meja->nomor_meja : '-' }}</span>
                                                <span><i class="fas fa-calendar mr-1"></i>{{ $pesan->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 mt-3 md:mt-0">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                {{ $pesan->status === 'sedang diproses' ? 'bg-orange-100 text-orenTua' :
                                                   ($pesan->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                                <i class="fas fa-circle mr-1 text-xs"></i>
                                                {{ ucfirst($pesan->status) }}
                                            </span>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                <i class="fas fa-credit-card mr-1"></i>
                                                {{ ucfirst($pesan->payment_method) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                        <i class="fas fa-list mr-2"></i>Item Pesanan
                                    </h3>

                                    <div class="space-y-4">
                                        @foreach ($pesan->menus as $menu)
                                            <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                                                <div class="flex items-center flex-1">
                                                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                                        <img src="{{ asset('storage/' . $menu->gambar) }}"
                                                             alt="{{ $menu->nama }}"
                                                             class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="ml-4 flex-1">
                                                        <h4 class="font-medium text-gray-800">{{ $menu->nama }}</h4>
                                                        <p class="text-sm text-gray-600">
                                                            Rp {{ number_format($menu->harga, 0, ',', '.') }} x {{ $menu->pivot->quantity }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <p class="font-semibold text-gray-800">
                                                        Rp {{ number_format($menu->harga * $menu->pivot->quantity, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Order Total -->
                                    <div class="mt-6 pt-4 border-t">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-semibold text-gray-800">Total Pembayaran:</span>
                                            <span class="text-2xl font-bold text-hijau1">
                                                Rp {{ number_format($pesan->total, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Back to Menu Button -->
                    <div class="mt-8 text-center">
                        <a href="{{ route('menu.show') }}"
                           class="inline-flex items-center bg-hijau1 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium text-lg">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Menu Utama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-hijau1 text-putih py-6 mt-12">
        <div class="container mx-auto text-center">
            <p class="text-sm font-semibold">© {{ date('Y') }} QRasa. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
