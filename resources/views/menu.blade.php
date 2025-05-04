<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentStore->name ?? 'Menu Warung' }}</title>
    <meta name="description" content="Menu makanan online">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="{
        sidebarOpen: false,
        cartOpen: false,
        currentStore: {{ json_encode($stores[0] ?? ['id' => 1, 'name' => 'Toko A', 'image' => '/img/placeholder.jpg']) }},
        stores: {{ json_encode($stores ?? [
            ['id' => 1, 'name' => 'Kantin Afwah', 'image' => '/img/Kantin/kantin_afwah.png'],
            ['id' => 2, 'name' => 'Kantin Dinda', 'image' => '/img/Kantin/kantin_dinda.png'],
            ['id' => 3, 'name' => 'Kantin Maknyus', 'image' => '/img/Kantin/kantin_maknyus.png']
        ]) }},
        menuItems: {{ json_encode($menuItems ?? [
            [
                'id' => 1,
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar',
                'price' => 25000,
                'discount' => 0,
                'image' => '/img/Menu/nasi_goreng.png'
            ],
            [
                'id' => 2,
                'name' => 'Mie Ayam',
                'description' => 'Mie dengan potongan ayam, sayuran, dan bumbu khas',
                'price' => 20000,
                'discount' => 10,
                'image' => '/img/placeholder.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Sate Ayam',
                'description' => 'Sate ayam dengan bumbu kacang khas Indonesia',
                'price' => 30000,
                'discount' => 0,
                'image' => '/img/placeholder.jpg'
            ],
            [
                'id' => 4,
                'name' => 'Gado-gado',
                'description' => 'Sayuran segar dengan bumbu kacang dan kerupuk',
                'price' => 18000,
                'discount' => 5,
                'image' => '/img/placeholder.jpg'
            ],
            [
                'id' => 5,
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis dingin yang menyegarkan',
                'price' => 5000,
                'discount' => 0,
                'image' => '/img/placeholder.jpg'
            ],
            [
                'id' => 6,
                'name' => 'Jus Alpukat',
                'description' => 'Jus alpukat segar dengan susu dan gula',
                'price' => 15000,
                'discount' => 0,
                'image' => '/img/placeholder.jpg'
            ]
        ]) }},
        cart: [],

        changeStore(store) {
            this.currentStore = store;
            this.sidebarOpen = false;
        },

        addToCart(item) {
            const existingItem = this.cart.find(cartItem => cartItem.id === item.id);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                this.cart.push({...item, quantity: 1});
            }
        },

        removeFromCart(id) {
            this.cart = this.cart.filter(item => item.id !== id);
        },

        updateQuantity(id, quantity) {
            if (quantity <= 0) {
                this.removeFromCart(id);
                return;
            }

            const item = this.cart.find(item => item.id === id);
            if (item) {
                item.quantity = quantity;
            }
        },

        calculateTotal() {
            return this.cart.reduce((total, item) => {
                const discountedPrice = item.price - (item.price * item.discount / 100);
                return total + (discountedPrice * item.quantity);
            }, 0);
        },

        formatPrice(price) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(price);
        },

        getTotalItems() {
            return this.cart.reduce((total, item) => total + item.quantity, 0);
        }
    }" class="min-h-screen flex flex-col">

    <div class="flex flex-1">
        <!-- Sidebar for store selection -->
        <div x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:w-64 md:min-h-screen">

            <div class="flex flex-col h-full">
                <div class="p-4 border-b">
                    <h2 class="text-xl font-bold text-center">Pilih Toko</h2>
                </div>

                <div class="flex-1 overflow-y-auto p-4">
                    <ul class="space-y-2">
                        <template x-for="store in stores" :key="store.id">
                            <li>
                                <button @click="changeStore(store)"
                                        :class="currentStore.id === store.id ? 'bg-gray-100 font-bold' : ''"
                                        class="w-full text-left px-4 py-2 rounded-md hover:bg-gray-100 transition-colors">
                                    <span x-text="store.name"></span>
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col md:ml-0">
            <!-- Header -->
            <header class="sticky top-0 z-40 bg-white shadow-sm p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="mr-4 md:hidden">
                        <i class="fas fa-bars text-gray-700 text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold" x-text="currentStore.name"></h1>
                </div>

                <!-- Shopping cart button -->
                <button @click="cartOpen = true" class="relative p-2">
                    <i class="fas fa-shopping-cart text-gray-700 text-xl"></i>
                    <span x-show="getTotalItems() > 0"
                          x-text="getTotalItems()"
                          class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                    </span>
                </button>
            </header>

            <!-- Main content area -->
            <div class="p-4">
                <!-- Store banner image -->
                <div class="relative h-40 w-full overflow-hidden rounded-lg mb-6">
                    <img :src="currentStore.image" :alt="currentStore.name" class="w-full h-full object-cover">
                </div>

                <h2 class="text-2xl font-bold mb-6">Menu Makanan</h2>

                <!-- Menu items grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="item in menuItems" :key="item.id">
                        <div class="bg-white rounded-lg overflow-hidden shadow-md">
                            <div class="relative h-48 w-full">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                                <span x-show="item.discount > 0"
                                      x-text="item.discount + '% OFF'"
                                      class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-md">
                                </span>
                            </div>

                            <div class="p-4">
                                <h3 class="font-bold" x-text="item.name"></h3>
                                <p class="mt-1 text-sm text-gray-500" x-text="item.description"></p>

                                <div class="mt-2 flex items-center gap-2">
                                    <span class="font-bold" x-text="formatPrice(item.price - (item.price * item.discount / 100))"></span>
                                    <span x-show="item.discount > 0"
                                          x-text="formatPrice(item.price)"
                                          class="text-sm text-gray-500 line-through">
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 pt-0">
                                <button @click="addToCart(item)"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">
                                    Pesan
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Shopping cart sidebar -->
        <div x-cloak x-show="cartOpen"
             class="fixed inset-0 z-50 overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div class="absolute inset-0 bg-gray-500 bg-opacity-75" @click="cartOpen = false"></div>

            <div class="fixed inset-y-0 right-0 max-w-full flex">
                <div x-show="cartOpen"
                     class="w-screen max-w-md"
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full">

                    <div class="h-full flex flex-col bg-white shadow-xl">
                        <div class="p-4 border-b">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium">Keranjang Belanja</h2>
                                <button @click="cartOpen = false" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-4">
                            <div x-show="cart.length === 0" class="text-center text-gray-500 py-8">
                                Keranjang belanja kosong
                            </div>

                            <div x-show="cart.length > 0" class="space-y-4">
                                <template x-for="item in cart" :key="item.id">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex-1">
                                            <h3 class="font-medium" x-text="item.name"></h3>
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm">
                                                    <span x-text="formatPrice(item.price - (item.price * item.discount / 100))"></span>
                                                    <span> x </span>
                                                    <span x-text="item.quantity"></span>
                                                </p>
                                                <span x-show="item.discount > 0"
                                                      x-text="item.discount + '% OFF'"
                                                      class="text-xs px-2 py-0.5 bg-gray-100 rounded-full">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <button @click="updateQuantity(item.id, item.quantity - 1)"
                                                    class="h-7 w-7 flex items-center justify-center rounded-md border border-gray-300 hover:bg-gray-100">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>

                                            <span class="w-5 text-center" x-text="item.quantity"></span>

                                            <button @click="updateQuantity(item.id, item.quantity + 1)"
                                                    class="h-7 w-7 flex items-center justify-center rounded-md border border-gray-300 hover:bg-gray-100">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>

                                            <button @click="removeFromCart(item.id)"
                                                    class="h-7 w-7 flex items-center justify-center rounded-md text-red-500 hover:bg-red-50">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div x-show="cart.length > 0" class="border-t p-4 space-y-4">
                            <div class="flex items-center justify-between pt-2">
                                <span class="font-medium">Total</span>
                                <span class="font-bold" x-text="formatPrice(calculateTotal())"></span>
                            </div>

                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-md transition-colors">
                                Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
