<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $selectedBanner ? $selectedBanner->nama : 'Menu Warung' }}</title>
    <meta name="description" content="Menu makanan online">
    @vite(['resources/css/app.css'])
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('img/Logo/LogoKantin.png') }}">

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
        <header class="sticky top-0 z-40 bg-hijau1 shadow-sm p-4 flex items-center justify-between">
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-putih">
                    {{ $selectedBanner ? $selectedBanner->nama : 'Semua Kantin' }}
                </h1>
            </div>
            <button @click="cartOpen = true" class="relative p-2">
                <i class="fas fa-shopping-cart text-putih text-xl"></i>
                <span x-show="getTotalItems() > 0" x-text="getTotalItems()"
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                </span>
            </button>
        </header>

        <!-- Navigation Bar -->
        <nav class="bg-white shadow-lg sticky top-[72px] z-30">
            <div class="overflow-x-auto">
                <div class="flex space-x-2 p-4 whitespace-nowrap">
                    <a href="{{ route('menu.show') }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                        {{ request('banner_id') == null ? 'bg-hijau1 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua Kantin
                    </a>
                    @foreach ($banners as $banner)
                        <a href="{{ route('menu.show', ['banner_id' => $banner->id]) }}"
                            class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                            {{ request('banner_id') == $banner->id ? 'bg-hijau1 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $banner->nama }}
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <div class="flex-1">
            <!-- Main Content -->
            <main class="flex-1 p-4 ">
                <!-- Banner -->
                <div class="p-6 flex justify-center items-center">
                    @if ($selectedBanner)
                        <div class="w-full sm:w-2/3 md:w-1/2">
                            <div class="relative h-50 w-80 rounded-lg overflow-hidden shadow-md">
                                <img src="{{ asset('storage/' . $selectedBanner->gambar) }}"
                                    alt="{{ $selectedBanner->nama }}"
                                    class="w-full h-full object-contain object-center bg-white">
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-sm px-3 py-2">
                                    <span>{{ $selectedBanner->nama }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Search -->
                <div class="relative mb-6">
                    <input type="text" x-model="searchQuery" placeholder="Apa yang kamu cari?"
                        class="w-full p-4 pl-10 text-sm border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <button x-show="searchQuery" @click="searchQuery = ''"
                        class="absolute right-2.5 bottom-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm px-4 py-2">
                        Clear
                    </button>
                </div>

                <h2 class="text-2xl font-bold mb-6">Paket Hemat</h2>

                <h2 class="text-2xl font-bold mb-6">Menu Baru</h2>

                <h2 class="text-2xl font-bold mb-6">Makanan</h2>

                <!-- Menu List -->
                <div x-show="filteredMenuItems().length > 0" class="space-y-4 mb-6">
                    <template x-for="item in filteredMenuItems()" :key="item.id">
                        <div class="bg-white p-4 flex items-center justify-between">
                            <!-- Image and Name Section -->
                            <div class="flex items-center space-x-4">
                                <div class="relative w-20 h-20">
                                    <img :src="item.image" :alt="item.name"
                                        class="w-full h-full rounded-lg object-cover">
                                    <div x-show="item.discount > 0"
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                                        <i class="fas fa-percent text-xs text-black"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800" x-text="item.name"></h3>
                                    <div class="flex items-center space-x-2">
                                        <p class="text-sm font-bold text-gray-800"
                                            x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                        </p>
                                        <template x-if="item.discount > 0">
                                            <p class="text-xs line-through text-gray-400"
                                                x-text="formatPrice(item.price)"></p>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button @click="addToCart(item)"
                                class="px-6 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm">
                                Tambah
                            </button>
                        </div>
                    </template>
                </div>

                <h2 class="text-2xl font-bold mb-6">Minuman</h2>

                <!-- Menu List Minuman -->
                <div x-show="filteredDrinkItems().length > 0" class="space-y-4 mb-6">
                    <template x-for="item in filteredDrinkItems()" :key="item.id">
                        <div class="bg-white p-4 flex items-center justify-between">
                            <!-- Image and Name Section -->
                            <div class="flex items-center space-x-4">
                                <div class="relative w-20 h-20">
                                    <img :src="item.image" :alt="item.name"
                                        class="w-full h-full rounded-lg object-cover">
                                    <div x-show="item.discount > 0"
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                                        <i class="fas fa-percent text-xs text-black"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800" x-text="item.name"></h3>
                                    <div class="flex items-center space-x-2">
                                        <p class="text-sm font-bold text-gray-800"
                                            x-text="formatPrice(item.price - (item.price * item.discount / 100))">
                                        </p>
                                        <template x-if="item.discount > 0">
                                            <p class="text-xs line-through text-gray-400"
                                                x-text="formatPrice(item.price)"></p>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button @click="addToCart(item)"
                                class="px-6 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm">
                                Tambah
                            </button>
                        </div>
                    </template>
                </div>

                <h2 class="text-2xl font-bold mb-6">Snack</h2>

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
                    nama: @json($banners->first()->nama)
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
                }
            };
        }
    </script>
</body>

</html>
