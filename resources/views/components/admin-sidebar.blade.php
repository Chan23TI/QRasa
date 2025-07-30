@props(['title' => 'Menu Management'])

<!-- Sidebar -->
<div {{ $attributes->merge(['class' => 'w-64 bg-white shadow-lg fixed left-0 top-0 bottom-0 overflow-y-auto flex flex-col']) }}>
    <!-- Sidebar Header dengan Logo -->
    <div class="p-6 flex items-center space-x-4">
        <img src="{{ asset('img/Logo/LogoKantin.png') }}" alt="Logo QRasa" class="w-10 h-10">
        <div>
            <h2 class="text-lg font-bold text-gray-800">QRasa</h2>
            <p class="text-sm text-gray-600">Panel Admin</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="px-4 flex-1">
        <div class="space-y-4">
            <!-- Menu Management -->
            <div>
                <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Manajemen Menu
                </p>
                <a href="{{ route('menu.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('menu.*') ? 'text-white bg-hijau1' : 'text-gray-600 hover:bg-gray-100' }} transition-colors duration-150">
                    <i class="fas fa-utensils w-5 h-5 mr-3"></i>
                    <span>Menu</span>
                </a>
            </div>

            <!-- Banner Management -->
            <div>
                <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Manajemen Kantin
                </p>
                <a href="{{ route('banner.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('banner.*') ? 'text-white bg-hijau1' : 'text-gray-600 hover:bg-gray-100' }} transition-colors duration-150">
                    <i class="fas fa-store w-5 h-5 mr-3"></i>
                    <span>Kantin</span>
                </a>
            </div>

            <!-- User Management -->
            <div>
                <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Manajemen Pengguna
                </p>
                <a href="{{ route('user.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('user.*') ? 'text-white bg-hijau1' : 'text-gray-600 hover:bg-gray-100' }} transition-colors duration-150">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>Pengguna</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Copyright -->
    <div class="p-4 border-t border-gray-200">
        <p class="text-xs text-gray-500 text-center">
            &copy; {{ date('Y') }} QRasa
            <br>
            <span class="text-gray-400">Version 1.0.0</span>
        </p>
    </div>
</div>
