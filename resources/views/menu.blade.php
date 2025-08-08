<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $selectedBanner ? $selectedBanner->nama : 'Menu Warung' }}</title>
    <meta name="description" content="Menu makanan online">
    @vite(['resources/css/app.css'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('img/Logo/LogoKantin.png') }} " loading="lazy">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div x-data="app()" x-init="init()" class="min-h-screen flex flex-col relative z-10">
        <!-- Meja Input Modal -->
        <div x-show="showMejaInput" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
            x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="bg-white p-8 rounded-lg shadow-2xl max-w-sm w-full mx-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Masukkan Nomor Meja Anda</h2>
                <form @submit.prevent="submitMejaNumber">
                    <div class="mb-4">
                        <label for="meja_number" class="block text-gray-700 text-base font-semibold mb-2">Nomor
                            Meja:</label>
                        <input type="number" id="meja_number" x-model.number="mejaNumberInput"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau1 focus:border-hijau1 transition-all duration-200 text-lg text-center"
                            placeholder="Contoh: 4" required min="1">
                    </div>
                    <div class="flex items-center justify-center">
                        <button type="submit"
                            class="w-full bg-hijau1 hover:bg-hijau1/90 text-white font-bold py-3 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-hijau1 focus:ring-opacity-50 transition-all duration-200 mt-4">
                            Lanjutkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Header -->
        <header class="sticky top-0 z-40 bg-hijau1 shadow-md">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <img src="{{ asset('img/Logo/LogoKantin.png') }}" alt="Logo QRasa"
                            class="w-10 h-10 rounded-full mr-3 object-cover" loading="lazy">
                        <h1 class="text-putih text-xl font-bold">
                            QRasa
                        </h1>
                    </div>
                    <div class="flex flex-col items-center">
                        <h1 class="text-lg md:text-xl font-bold text-putih truncate max-w-[200px] md:max-w-none"
                            x-text="selectedBanner ? selectedBanner.nama : 'Semua Kantin'">
                        </h1>

                        <div x-show="mejaId" class="bg-orenTua/80 rounded-full px-3 py-0.5 mt-1">
                            <p class="text-putih text-xs font-medium">Meja: <span x-text="mejaId"></span></p>
                        </div>


                    </div>
                    <div class="flex items-center space-x-2">
                        <button @click="historyOpen = true"
                            class="relative p-2 hover:bg-hijau1/80 rounded-full transition-colors">
                            <i class="fas fa-history text-putih text-xl"></i>
                        </button>
                        <button @click="cartOpen = true"
                            class="relative p-2 hover:bg-hijau1/80 rounded-full transition-colors">
                            <i class="fas fa-shopping-cart text-putih text-xl"></i>
                            <span x-show="getTotalItems() > 0" x-text="getTotalItems()"
                                class="absolute -top-1 -right-1 bg-orenTua text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation Bar -->
        <nav class="bg-white shadow-lg sticky top-16 z-30">
            <div class="container mx-auto">
                <div class="overflow-x-auto scrollbar-hide">
                    <div class="flex space-x-2 p-4 whitespace-nowrap min-w-full">
                        <a href="#" @click.prevent="filterByCategory(null)"
                            :class="{
                                'bg-hijau1 text-white shadow-md': selectedBannerId === null,
                                'bg-gray-100 text-gray-700 hover:bg-gray-200': selectedBannerId !== null
                            }"
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-home mr-2"></i>
                            <span>Semua Kantin</span>
                        </a>
                        @foreach ($banners as $banner)
                            <a href="#" @click.prevent="filterByCategory({{ $banner->id }})"
                                :class="{
                                    'bg-hijau1 text-white shadow-md': selectedBannerId === {{ $banner->id }},
                                    'bg-gray-100 text-gray-700 hover:bg-gray-200': selectedBannerId !==
                                        {{ $banner->id }}
                                }"
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-store mr-2"></i>
                                <span>{{ $banner->nama }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex-1">
            <!-- Main Content -->
            <main class="flex-1 p-4 ">
                <!-- Banner -->
                <div class="container mx-auto px-4 py-6">
                    <div x-show="selectedBanner" class="max-w-4xl mx-auto">
                        <div class="relative rounded-xl overflow-hidden shadow-lg aspect-w-16 aspect-h-9">
                            <img x-bind:src="selectedBanner ? '{{ asset('storage/') }}/' + selectedBanner.gambar : ''"
                                x-bind:alt="selectedBanner ? selectedBanner.nama : ''" loading="lazy"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6">
                                <h2 class="text-white text-xl md:text-2xl font-bold"
                                    x-text="selectedBanner ? selectedBanner.nama : ''">
                                </h2>
                                <p x-show="selectedBanner && selectedBanner.deskripsi"
                                    class="text-white/90 text-sm md:text-base mt-2"
                                    x-text="selectedBanner ? selectedBanner.deskripsi : ''"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="container mx-auto px-4 mb-8">
                    <div class="max-w-2xl mx-auto relative">
                        <input type="text" x-model="searchQuery" placeholder="Cari menu favoritmu..."
                            class="w-full p-4 pl-12 text-base border-2 border-gray-200 rounded-full focus:ring-2 focus:ring-hijau1 focus:border-hijau1 transition-all duration-200 shadow-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i class="fas fa-search text-gray-400 text-lg"></i>
                        </div>
                        <div x-show="searchQuery" @click="searchQuery = ''"
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 rounded-full p-2 transition-all duration-200">
                            <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <h2 class="text-2xl font-bold mb-6" x-show="filteredPaketItems().length > 0">Paket Hemat</h2>
                <!-- Menu List Paket Hemat -->
                <div x-show="filteredPaketItems().length > 0"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                    <template x-for="item in filteredPaketItems()" :key="item.id">
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <!-- Image Section -->
                            <div class="relative aspect-square w-full overflow-hidden">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover"
                                    loading="lazy">
                                <div x-show="item.discount > 0"
                                    class="absolute top-2 right-2 bg-orenTua text-white text-xs font-bold px-2 py-1 rounded-lg shadow-md">
                                    <span x-text="item.discount + '%'"></span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm sm:text-base mb-1 truncate"
                                    x-text="item.name">
                                </h3>
                                <div class="flex flex-col space-y-1 mb-2">
                                    <p class="text-sm sm:text-base font-bold text-hijau1"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                    </p>
                                    <template x-if="item.discount > 0">
                                        <p class="text-xs text-gray-400 line-through" x-text="formatPrice(item.price)">
                                        </p>
                                    </template>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart(item)" :disabled="item.stok <= 0"
                                    :class="{ 'opacity-50 cursor-not-allowed': item.stok <= 0 }"
                                    class="w-full px-3 py-1.5 bg-hijau1 text-white text-sm rounded-lg hover:bg-hijau1/90 transition-colors duration-200 flex items-center justify-center space-x-1 group">
                                    <i class="fas fa-plus text-xs transition-transform duration-300"></i>
                                    <span x-text="item.stok <= 0 ? 'Habis' : 'Tambah'"></span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <h2 class="text-2xl font-bold mb-6 " x-show="filteredMenuBaruItems().length > 0">Menu Baru</h2>

                <!-- Menu Baru List -->
                <div x-show="filteredMenuBaruItems().length > 0"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                    <template x-for="item in filteredMenuBaruItems()" :key="item.id">
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <!-- Image Section -->
                            <div class="relative aspect-square w-full overflow-hidden">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover"
                                    loading="lazy">
                                <div x-show="item.discount > 0"
                                    class="absolute top-2 right-2 bg-orenTua text-white text-xs font-bold px-2 py-1 rounded-lg shadow-md">
                                    <span x-text="item.discount + '%'"></span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm sm:text-base mb-1 truncate"
                                    x-text="item.name">
                                </h3>
                                <div class="flex flex-col space-y-1 mb-2">
                                    <p class="text-sm sm:text-base font-bold text-hijau1"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                    </p>
                                    <template x-if="item.discount > 0">
                                        <p class="text-xs text-gray-400 line-through" x-text="formatPrice(item.price)"></p>
                                    </template>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart(item)" :disabled="item.stok <= 0"
                                    :class="{ 'opacity-50 cursor-not-allowed': item.stok <= 0 }"
                                    class="w-full px-3 py-1.5 bg-hijau1 text-white text-sm rounded-lg hover:bg-hijau1/90 transition-colors duration-200 flex items-center justify-center space-x-1 group">
                                    <i class="fas fa-plus text-xs transition-transform duration-300"></i>
                                    <span x-text="item.stok <= 0 ? 'Habis' : 'Tambah'"></span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <h2 class="text-2xl font-bold mb-6" x-show="filteredMenuItems().length > 0">Makanan</h2>

                <!-- Menu List -->
                <div x-show="filteredMenuItems().length > 0"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                    <template x-for="item in filteredMenuItems()" :key="item.id">
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <!-- Image Section -->
                            <div class="relative aspect-square w-full overflow-hidden">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover"
                                    loading="lazy">
                                <div x-show="item.discount > 0"
                                    class="absolute top-2 right-2 bg-orenTua text-white text-xs font-bold px-2 py-1 rounded-lg shadow-md">
                                    <span x-text="item.discount + '%'"></span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm sm:text-base mb-1 truncate"
                                    x-text="item.name">
                                </h3>
                                <div class="flex flex-col space-y-1 mb-2">
                                    <p class="text-sm sm:text-base font-bold text-hijau1"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                    </p>
                                    <template x-if="item.discount > 0">
                                        <p class="text-xs text-gray-400 line-through" x-text="formatPrice(item.price)"></p>
                                    </template>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart(item)" :disabled="item.stok <= 0"
                                    :class="{ 'opacity-50 cursor-not-allowed': item.stok <= 0 }"
                                    class="w-full px-3 py-1.5 bg-hijau1 text-white text-sm rounded-lg hover:bg-hijau1/90 transition-colors duration-200 flex items-center justify-center space-x-1 group">
                                    <i class="fas fa-plus text-xs transition-transform duration-300"></i>
                                    <span x-text="item.stok <= 0 ? 'Habis' : 'Tambah'"></span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <h2 class="text-2xl font-bold mb-6" x-show="filteredDrinkItems().length > 0">Minuman</h2>

                <!-- Menu List Minuman -->
                <div x-show="filteredDrinkItems().length > 0"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                    <template x-for="item in filteredDrinkItems()" :key="item.id">
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <!-- Image Section -->
                            <div class="relative aspect-square w-full overflow-hidden">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover"
                                    loading="lazy">
                                <div x-show="item.discount > 0"
                                    class="absolute top-2 right-2 bg-orenTua text-white text-xs font-bold px-2 py-1 rounded-lg shadow-md">
                                    <span x-text="item.discount + '%'"></span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm sm:text-base mb-1 truncate"
                                    x-text="item.name">
                                </h3>
                                <div class="flex flex-col space-y-1 mb-2">
                                    <p class="text-sm sm:text-base font-bold text-hijau1"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                    </p>
                                    <template x-if="item.discount > 0">
                                        <p class="text-xs text-gray-400 line-through" x-text="formatPrice(item.price)"></p>
                                    </template>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart(item)" :disabled="item.stok <= 0"
                                    :class="{ 'opacity-50 cursor-not-allowed': item.stok <= 0 }"
                                    class="w-full px-3 py-1.5 bg-hijau1 text-white text-sm rounded-lg hover:bg-hijau1/90 transition-colors duration-200 flex items-center justify-center space-x-1 group">
                                    <i class="fas fa-plus text-xs transition-transform duration-300"></i>
                                    <span x-text="item.stok <= 0 ? 'Habis' : 'Tambah'"></span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <h2 class="text-2xl font-bold mb-6" x-show="filteredSnackItems().length > 0">Snack</h2>
                <!-- Menu List Snack -->
                <div x-show="filteredSnackItems().length > 0"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                    <template x-for="item in filteredSnackItems()" :key="item.id">
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <!-- Image Section -->
                            <div class="relative aspect-square w-full overflow-hidden">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover"
                                    loading="lazy">
                                <div x-show="item.discount > 0"
                                    class="absolute top-2 right-2 bg-orenTua text-white text-xs font-bold px-2 py-1 rounded-lg shadow-md">
                                    <span x-text="item.discount + '%'"></span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm sm:text-base mb-1 truncate"
                                    x-text="item.name">
                                </h3>
                                <div class="flex flex-col space-y-1 mb-2">
                                    <p class="text-sm sm:text-base font-bold text-hijau1"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                    </p>
                                    <template x-if="item.discount > 0">
                                        <p class="text-xs text-gray-400 line-through" x-text="formatPrice(item.price)"></p>
                                    </template>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart(item)" :disabled="item.stok <= 0"
                                    :class="{ 'opacity-50 cursor-not-allowed': item.stok <= 0 }"
                                    class="w-full px-3 py-1.5 bg-hijau1 text-white text-sm rounded-lg hover:bg-hijau1/90 transition-colors duration-200 flex items-center justify-center space-x-1 group">
                                    <i class="fas fa-plus text-xs transition-transform duration-300"></i>
                                    <span x-text="item.stok <= 0 ? 'Habis' : 'Tambah'"></span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </main>

        <!-- Cart -->
        <div x-show="cartOpen"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end md:items-center justify-center"
            @click.self="cartOpen = false" x-cloak>
            <div class="bg-white w-full md:max-w-md p-6 rounded-t-lg md:rounded-lg max-h-full overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Keranjang</h2>
                    <button @click="cartOpen = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <template x-if="cart.length > 0">
                    <div class="space-y-4">
                        <template x-for="item in cart" :key="item.id">
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <h4 class="font-semibold" x-text="item.name"></h4>
                                    <div class="text-sm text-gray-500"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100)) + ' x ' + item.quantity">
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="number" min="1" class="w-12 text-center border rounded"
                                        x-model.number="item.quantity"
                                        @input="updateQuantity(item.id, item.quantity)">
                                    <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div class="pt-4 font-bold text-right">
                            Total: <span x-text="formatPrice(calculateTotal())"></span>
                        </div>
                        <div class="pt-4">
                            <select x-model="paymentMethod"
                                class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-hijau1 focus:border-hijau1 appearance-none mb-2">
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="cash">Tunai</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="qris">QRIS</option>
                            </select>
                            <button @click="checkout" x-bind:disabled="!paymentMethod || cart.length === 0"
                                class="w-full bg-oren text-white font-semibold py-2 px-4 rounded hover:bg-orange-500 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                Checkout
                            </button>
                        </div>
                    </div>
                </template>
                <template x-if="cart.length === 0">
                    <p class="text-gray-500 text-center">Keranjang kosong</p>
                </template>
            </div>
        </div>

        <!-- History Modal -->
        <div x-show="historyOpen"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end md:items-center justify-center"
            @click.self="historyOpen = false" x-cloak>
            <div class="bg-white w-full md:max-w-md p-6 rounded-t-lg md:rounded-lg max-h-full overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Riwayat Pesanan</h2>
                    <button @click="historyOpen = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <template x-if="historyPesanan.length > 0">
                    <div class="space-y-4">
                        <template x-for="pesanan in historyPesanan" :key="pesanan.id">
                            <div class="border-b pb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="font-semibold">Pesanan ID: <span x-text="pesanan.id"></span></p>
                                    <p class="text-sm text-gray-500" x-text="new Date(pesanan.created_at).toLocaleString('id-ID')"></p>
                                </div>
                                <template x-for="menu in pesanan.menus" :key="menu.id">
                                    <div class="flex items-center justify-between text-sm">
                                        <p x-text="menu.nama + ' (x' + menu.pivot.quantity + ')'"></p>
                                        <p x-text="formatPrice(menu.pivot.quantity * menu.harga)"></p>
                                    </div>
                                </template>
                                <div class="text-right font-bold mt-2">
                                    Total: <span x-text="formatPrice(pesanan.total)"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="historyPesanan.length === 0">
                    <p class="text-gray-500 text-center">Tidak ada riwayat pesanan untuk meja ini.</p>
                </template>
            </div>
        </div>
    </div>

    <footer>
        <div class="bg-hijau1 text-putih py-4">
            <div class="container mx-auto text-center">
                <p class="text-sm font-semibold">© {{ date('Y') }} QRasa. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function app() {
            return {
                cartOpen: false,
                historyOpen: false,
                banners: @json($banners),
                stores: [...new Set(@json($banners).map(b => b.nama))].map((name, index) => ({
                    id: index + 1,
                    nama: name
                })),
                currentStore: {
                    id: 1,
                    nama: @json(optional($banners->first())->nama ?? 'Semua Kantin')
                },
                menuItems: {!! json_encode(
                    $menu->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->nama,
                            'description' => $item->deskripsi,
                            'price' => $item->harga,
                            'discount' => $item->diskon ?? 0,
                            'image' => asset('storage/' . $item->gambar),
                            'stok' => $item->stok,
                            'category' => $item->kategori ?? 'Makanan', // Menambahkan kategori
                            'banner_id' => $item->banner_id, // Menambahkan banner_id
                        ];
                    }),
                ) !!},
                cart: [],
                searchQuery: '',
                mejaId: null,
                mejaNumberInput: '',
                showMejaInput: false,
                selectedBannerId: {{ request('banner_id') ?? 'null' }},
                selectedBanner: @json($selectedBanner),
                historyPesanan: @json($historyPesanan),
                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    this.mejaId = urlParams.get('meja_id');

                    if (!this.mejaId) {
                        this.showMejaInput = true;
                    }
                },
                submitMejaNumber() {
                    if (this.mejaNumberInput && this.mejaNumberInput > 0) {
                        this.mejaId = this.mejaNumberInput;
                        this.showMejaInput = false;
                        // Update URL with meja_id
                        const url = new URL(window.location.href);
                        url.searchParams.set('meja_id', this.mejaId);
                        window.history.pushState({}, '', url);
                    } else {
                        alert('Mohon masukkan nomor meja yang valid.');
                    }
                },
                changeStore(store) {
                    this.currentStore = store;
                },
                async filterByCategory(bannerId) {
                    this.selectedBannerId = bannerId;
                    const url = new URL('{{ route('menu.show') }}');
                    if (bannerId) {
                        url.searchParams.set('banner_id', bannerId);
                    }
                    if (this.mejaId) {
                        url.searchParams.set('meja_id', this.mejaId);
                    }

                    try {
                        const response = await fetch(url.toString(), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const data = await response.json();
                        this.menuItems = data.menu.map(item => ({
                            id: item.id,
                            name: item.nama,
                            description: item.deskripsi,
                            price: item.harga,
                            discount: item.diskon ?? 0,
                            image: `{{ asset('storage/') }}/${item.gambar}`,
                            stok: item.stok,
                            category: item.kategori ?? 'Makanan',
                            banner_id: item.banner_id,
                        }));
                        // Update selectedBanner if needed, though it's mostly for initial load
                        this.selectedBanner = data.selectedBanner; // If you want to update banner info on top
                        window.history.pushState({}, '', url.toString()); // Update URL in browser history
                    } catch (error) {
                        console.error('Error fetching menu items:', error);
                        alert('Gagal memuat menu. Silakan coba lagi.');
                    }
                },
                addToCart(item) {
                    if (item.stok <= 0) {
                        alert('Stok untuk menu ini sudah habis.');
                        return;
                    }
                    if (!this.mejaId) {
                        alert('Mohon masukkan nomor meja terlebih dahulu.');
                        this.showMejaInput = true;
                        return;
                    }
                    const existing = this.cart.find(i => i.id === item.id);
                    if (existing) {
                        if (existing.quantity >= item.stok) {
                            alert('Anda tidak dapat menambahkan melebihi jumlah stok yang tersedia.');
                            return;
                        }
                        existing.quantity++;
                    } else {
                        this.cart.push({
                            ...item,
                            quantity: 1
                        });
                    }
                },
                removeFromCart(id) {
                    this.cart = this.cart.filter(i => i.id !== id);
                },
                updateQuantity(id, quantity) {
                    const item = this.cart.find(i => i.id === id);
                    if (item) {
                        if (quantity < 1) return this.removeFromCart(id);
                        item.quantity = quantity;
                    }
                },
                calculateTotal() {
                    return this.cart.reduce((t, i) => t + (i.price - (i.price * i.discount / 100)) * i.quantity, 0);
                },
                formatPrice(price) {
                    return 'Rp ' + price.toLocaleString('id-ID');
                },
                getTotalItems() {
                    return this.cart.reduce((t, i) => t + i.quantity, 0);
                },
                paymentMethod: '', // New property for payment method
                // Perbaikan untuk fungsi checkout() di dalam script Alpine.js
                checkout() {
                    if (this.cart.length === 0 || !this.paymentMethod) {
                        alert('Keranjang kosong atau metode pembayaran belum dipilih!');
                        return;
                    }

                    if (!this.mejaId) {
                        alert('Mohon masukkan nomor meja terlebih dahulu sebelum checkout.');
                        this.showMejaInput = true;
                        return;
                    }

                    // Group cart items by banner_id
                    const groupedCartItems = this.cart.reduce((acc, item) => {
                        const bannerId = item.banner_id;
                        if (!acc[bannerId]) {
                            acc[bannerId] = {
                                banner_id: bannerId,
                                items: [],
                                total: 0
                            };
                        }
                        acc[bannerId].items.push({
                            id: item.id,
                            quantity: item.quantity
                        });
                        acc[bannerId].total += (item.price - (item.price * item.discount / 100)) * item.quantity;
                        return acc;
                    }, {});

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                        '{{ csrf_token() }}';

                    const promises = Object.values(groupedCartItems).map(group => {
                        const postData = {
                            cartItems: group.items,
                            total: group.total,
                            payment_method: this.paymentMethod,
                            meja_id: this.mejaId,
                            banner_id: group.banner_id // Pass banner_id to backend
                        };

                        console.log('Mengirim data checkout untuk banner_id:', group.banner_id, postData);

                        return fetch('{{ route('pesan.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify(postData)
                            })
                            .then(response => {
                                if (response.status === 302 || response.status === 301) {
                                    const redirectUrl = response.headers.get('Location') || '/login';
                                    alert('Session expired atau perlu login. Mengalihkan ke halaman login...');
                                    window.location.href = redirectUrl;
                                    return Promise.reject('Redirect detected');
                                }
                                const contentType = response.headers.get('content-type');
                                if (!contentType || !contentType.includes('application/json')) {
                                    return response.text().then(text => {
                                        throw new Error(
                                            `Expected JSON but got ${contentType}. Response: ${text.substring(0, 100)}...`
                                        );
                                    });
                                }
                                if (!response.ok) {
                                    return response.json().then(err => {
                                        throw new Error(
                                            `HTTP error! status: ${response.status}, message: ${err.message || JSON.stringify(err)}`
                                        );
                                    });
                                }
                                return response.json();
                            });
                    });

                    Promise.all(promises)
                        .then(responses => {
                            let allCreatedPesanIds = [];
                            let allMessages = [];
                            let hasError = false;

                            responses.forEach(data => {
                                if (data.success) {
                                    allCreatedPesanIds = allCreatedPesanIds.concat(data.created_pesan_ids);
                                    allMessages.push(data.message);
                                } else {
                                    hasError = true;
                                    allMessages.push('Terjadi kesalahan: ' + (data.message ||
                                        'Silakan coba lagi.'));
                                }
                            });

                            if (hasError) {
                                alert('Beberapa pesanan mungkin gagal dibuat:\n' + allMessages.join('\n'));
                            } else {
                                alert('Semua pesanan berhasil dibuat!');
                            }

                            this.cart = []; // Clear cart
                            this.cartOpen = false; // Close cart

                            if (allCreatedPesanIds.length > 0) {
                                window.location.href = `{{ route('pesan.multi_summary', ['ids' => '__IDS__']) }}`
                                    .replace('__IDS__', allCreatedPesanIds.join(','));
                            } else {
                                alert('Tidak ada pesanan yang berhasil dibuat.');
                            }
                        })
                        .catch(error => {
                            console.error('Error saat checkout:', error);
                            if (error.message !== 'Redirect detected') {
                                alert('Terjadi kesalahan saat memproses pesanan: ' + error.message);
                            }
                        });
                },
                filteredMenuBaruItems() {
                    return this.menuItems.filter(item =>
                        item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) &&
                        item.category === 'Menu Baru'
                    );
                },
                filteredMenuItems() {
                    return this.menuItems.filter(item =>
                        item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) &&
                        item.category === 'Makanan'
                    );
                },
                filteredDrinkItems() {
                    return this.menuItems.filter(item =>
                        item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) &&
                        item.category === 'Minuman'
                    );
                },
                filteredPaketItems() {
                    return this.menuItems.filter(item =>
                        item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) &&
                        item.category === 'Paket Hemat'
                    );
                },
                filteredSnackItems() {
                    return this.menuItems.filter(item =>
                        item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) &&
                        item.category === 'Snack'
                    );
                }
            };
        }
    </script>
</body>

</html>
