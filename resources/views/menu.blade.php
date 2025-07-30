<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $selectedBanner ? $selectedBanner->nama : 'Menu Warung' }}</title>
    <meta name="description" content="Menu makanan online">
    @vite(['resources/css/app.css'])
    <!--                     nama: @json($banners->first() ? $banners->first()->nama : ''),ailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

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
    <div x-data="app()" x-init="init()" class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="sticky top-0 z-40 bg-hijau1 shadow-md">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-lg md:text-xl font-bold text-putih truncate max-w-[200px] md:max-w-none">
                            {{ $selectedBanner ? $selectedBanner->nama : 'Semua Kantin' }}
                        </h1>
                    </div>
                    <button @click="cartOpen = true" class="relative p-2 hover:bg-hijau1/80 rounded-full transition-colors">
                        <i class="fas fa-shopping-cart text-putih text-xl"></i>
                        <span x-show="getTotalItems() > 0" x-text="getTotalItems()"
                            class="absolute -top-1 -right-1 bg-orenTua text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                        </span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Navigation Bar -->
        <nav class="bg-white shadow-lg sticky top-16 z-30">
            <div class="container mx-auto">
                <div class="overflow-x-auto scrollbar-hide">
                    <div class="flex space-x-2 p-4 whitespace-nowrap min-w-full">
                        <a href="{{ route('menu.show') }}"
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 transform hover:scale-105
                            {{ request('banner_id') == null ? 'bg-hijau1 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            <i class="fas fa-home mr-2"></i>
                            <span>Semua Kantin</span>
                        </a>
                        @foreach ($banners as $banner)
                            <a href="{{ route('menu.show', ['banner_id' => $banner->id]) }}"
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 transform hover:scale-105
                                {{ request('banner_id') == $banner->id ? 'bg-hijau1 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
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
                    @if ($selectedBanner)
                        <div class="max-w-4xl mx-auto">
                            <div class="relative rounded-xl overflow-hidden shadow-lg aspect-w-16 aspect-h-9">
                                <img src="{{ asset('storage/' . $selectedBanner->gambar) }}"
                                    alt="{{ $selectedBanner->nama }}" loading="lazy"
                                    class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6">
                                    <h2 class="text-white text-xl md:text-2xl font-bold">{{ $selectedBanner->nama }}</h2>
                                    @if($selectedBanner->deskripsi)
                                        <p class="text-white/90 text-sm md:text-base mt-2">{{ $selectedBanner->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Search -->
                <div class="container mx-auto px-4 mb-8">
                    <div class="max-w-2xl mx-auto relative">
                        <input type="text" x-model="searchQuery" placeholder="Cari menu favoritmu..."
                            class="w-full p-4 pl-12 text-base border-2 border-gray-200 rounded-full focus:ring-2 focus:ring-hijau1 focus:border-hijau1 transition-all duration-200 shadow-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i class="fas fa-search text-gray-400 text-lg"></i>
                        </div>
                        <button x-show="searchQuery" @click="searchQuery = ''"
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 rounded-full p-2 transition-all duration-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <h2 class="text-2xl font-bold mb-6">Paket Hemat</h2>
                <!-- Menu List Paket Hemat -->
                <div x-show="filteredPaketItems().length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                    <template x-for="item in filteredPaketItems()" :key="item.id">
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <!-- Image Section -->
                            <div class="relative aspect-square w-full overflow-hidden">
                                <img :src="item.image" :alt="item.name"
                                    class="w-full h-full object-cover" loading="lazy">
                                <div x-show="item.discount > 0"
                                    class="absolute top-2 right-2 bg-orenTua text-white text-xs font-bold px-2 py-1 rounded-lg shadow-md">
                                    <span x-text="item.discount + '%'"></span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm sm:text-base mb-1 truncate" x-text="item.name"></h3>
                                <div class="flex flex-col space-y-1 mb-2">
                                    <p class="text-sm sm:text-base font-bold text-hijau1"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                    </p>
                                    <template x-if="item.discount > 0">
                                        <p class="text-xs text-gray-400 line-through"
                                            x-text="formatPrice(item.price)"></p>
                                    </template>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart(item)"
                                    class="w-full px-3 py-1.5 bg-hijau1 text-white text-sm rounded-lg hover:bg-hijau1/90 transition-colors duration-200 flex items-center justify-center space-x-1 group">
                                    <i class="fas fa-plus text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                                    <span>Tambah</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <h2 class="text-2xl font-bold mb-6">Menu Baru</h2>

                <h2 class="text-2xl font-bold mb-6">Makanan</h2>

                <!-- Menu List -->
                <div x-show="filteredMenuItems().length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                    <template x-for="item in filteredMenuItems()" :key="item.id">
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <!-- Image Section -->
                            <div class="relative aspect-square w-full overflow-hidden">
                                <img :src="item.image" :alt="item.name"
                                    class="w-full h-full object-cover" loading="lazy">
                                <div x-show="item.discount > 0"
                                    class="absolute top-2 right-2 bg-orenTua text-white text-xs font-bold px-2 py-1 rounded-lg shadow-md">
                                    <span x-text="item.discount + '%'"></span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm sm:text-base mb-1 truncate" x-text="item.name"></h3>
                                <div class="flex flex-col space-y-1 mb-2">
                                    <p class="text-sm sm:text-base font-bold text-hijau1"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                    </p>
                                    <template x-if="item.discount > 0">
                                        <p class="text-xs text-gray-400 line-through"
                                            x-text="formatPrice(item.price)"></p>
                                    </template>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart(item)"
                                    class="w-full px-3 py-1.5 bg-hijau1 text-white text-sm rounded-lg hover:bg-hijau1/90 transition-colors duration-200 flex items-center justify-center space-x-1 group">
                                    <i class="fas fa-plus text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                                    <span>Tambah</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <h2 class="text-2xl font-bold mb-6">Minuman</h2>

                <!-- Menu List Minuman -->
                <div x-show="filteredDrinkItems().length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                    <template x-for="item in filteredDrinkItems()" :key="item.id">
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <!-- Image Section -->
                            <div class="relative aspect-square w-full overflow-hidden">
                                <img :src="item.image" :alt="item.name"
                                    class="w-full h-full object-cover" loading="lazy">
                                <div x-show="item.discount > 0"
                                    class="absolute top-2 right-2 bg-orenTua text-white text-xs font-bold px-2 py-1 rounded-lg shadow-md">
                                    <span x-text="item.discount + '%'"></span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm sm:text-base mb-1 truncate" x-text="item.name"></h3>
                                <div class="flex flex-col space-y-1 mb-2">
                                    <p class="text-sm sm:text-base font-bold text-hijau1"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                    </p>
                                    <template x-if="item.discount > 0">
                                        <p class="text-xs text-gray-400 line-through"
                                            x-text="formatPrice(item.price)"></p>
                                    </template>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart(item)"
                                    class="w-full px-3 py-1.5 bg-hijau1 text-white text-sm rounded-lg hover:bg-hijau1/90 transition-colors duration-200 flex items-center justify-center space-x-1 group">
                                    <i class="fas fa-plus text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                                    <span>Tambah</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>                <h2 class="text-2xl font-bold mb-6">Snack</h2>
                <!-- Menu List Snack -->
                <div x-show="filteredSnackItems().length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                    <template x-for="item in filteredSnackItems()" :key="item.id">
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <!-- Image Section -->
                            <div class="relative aspect-square w-full overflow-hidden">
                                <img :src="item.image" :alt="item.name"
                                    class="w-full h-full object-cover" loading="lazy">
                                <div x-show="item.discount > 0"
                                    class="absolute top-2 right-2 bg-orenTua text-white text-xs font-bold px-2 py-1 rounded-lg shadow-md">
                                    <span x-text="item.discount + '%'"></span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm sm:text-base mb-1 truncate" x-text="item.name"></h3>
                                <div class="flex flex-col space-y-1 mb-2">
                                    <p class="text-sm sm:text-base font-bold text-hijau1"
                                        x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                    </p>
                                    <template x-if="item.discount > 0">
                                        <p class="text-xs text-gray-400 line-through"
                                            x-text="formatPrice(item.price)"></p>
                                    </template>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart(item)"
                                    class="w-full px-3 py-1.5 bg-hijau1 text-white text-sm rounded-lg hover:bg-hijau1/90 transition-colors duration-200 flex items-center justify-center space-x-1 group">
                                    <i class="fas fa-plus text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                                    <span>Tambah</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

            </main>
        </div>

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
                            <button @click="checkout"
                                class="w-full bg-oren text-white font-semibold py-2 px-4 rounded hover:bg-orange-500 transition">
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
    </div>

    <script>
        function app() {
            return {
                cartOpen: false,
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
                        ];
                    }),
                ) !!},
                cart: [],
                searchQuery: '',
                init() {},
                changeStore(store) {
                    this.currentStore = store;
                },
                addToCart(item) {
                    const existing = this.cart.find(i => i.id === item.id);
                    if (existing) {
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
