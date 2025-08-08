@props(['title' => 'Menu Management'])

<!-- Sidebar -->
<div {{ $attributes->merge(['class' => 'w-64 bg-white shadow-lg fixed left-0 top-0 bottom-0 overflow-y-auto flex flex-col']) }}>
    <!-- Sidebar Header dengan Logo -->
    <div class="p-6 flex items-center space-x-4">
        <div>
            <h1 class="text-xl font-bold text-oren ">QRasa</h1>
            <p class="text-sm text-gray-600">Panel Admin</p>
        </div>
    </div>

    @auth
    <!-- Navigation -->
    <nav class="px-4 flex-1">
        <div class="space-y-4">


            <p class="text-gray-700 text-md font-bold">Manajemen Kelola</p>
            <!-- Menu Management -->
            <div>
                <a href="{{ route('menu.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('menu.*') ? 'text-white bg-oren' : 'text-gray-600 hover:bg-gray-100' }} transition-colors duration-150">
                    <i class="fas fa-utensils w-5 h-5 mr-3"></i>
                    <span>Menu</span>
                </a>
            </div>

            <!-- Banner Management -->
            <div>
                <a href="{{ route('banner.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('banner.*') ? 'text-white bg-oren' : 'text-gray-600 hover:bg-gray-100' }} transition-colors duration-150">
                    <i class="fas fa-store w-5 h-5 mr-3"></i>
                    <span>Kantin</span>
                </a>
            </div>

                        <!-- Dashboard Link -->
            @if (Auth::check() && Auth::user()->role !== 'admin')
            <div>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'text-white bg-oren' : 'text-gray-600 hover:bg-gray-100' }} transition-colors duration-150">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Penjualan</span>
                </a>
            </div>
            <div>
                <a href="{{ route('pesan.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('pesan.*') ? 'text-white bg-oren' : 'text-gray-600 hover:bg-gray-100' }} transition-colors duration-150">
                    <i class="fas fa-shopping-cart w-5 h-5 mr-3"></i>
                    <span>Pesanan</span>
                </a>
            </div>
            @endif

            <!-- Meja Management (Admin only) -->
            @if (Auth::check() && Auth::user()->role === 'admin')
            <div>
                <a href="{{ route('meja.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('meja.*') ? 'text-white bg-oren' : 'text-gray-600 hover:bg-gray-100' }} transition-colors duration-150">
                    <i class="fas fa-chair w-5 h-5 mr-3"></i>
                    <span>Meja</span>
                </a>
            </div>
            @endif

            <!-- User Management -->
            @if (Auth::check() && Auth::user()->role === 'admin')
            <div>
                <a href="{{ route('user.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('user.*') ? 'text-white bg-oren' : 'text-gray-600 hover:bg-gray-100' }} transition-colors duration-150">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>Pengguna</span>
                </a>
            </div>
            @endif
        </div>
    </nav>
    @endauth
    <!-- Logo Image-->
    <div class="flex items-center justify-center mt-auto mb-4">
        <img src="{{ asset('img/Logo/LogoKantin.png') }}" alt="Logo QRasa" class="w-20 h-20 rounded-xl object-cover" loading="lazy">
    </div>
    <!-- Copyright -->
    <div class="p-4 border-t border-gray-200">

        <p class="text-xs text-gray-500 text-center">
            &copy; {{ date('Y') }} QRasa
            <br>
            <span class="text-gray-400">Version 1.0.0</span>
        </p>
    </div>
</div>
