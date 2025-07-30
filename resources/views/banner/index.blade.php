<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        <x-admin-sidebar />

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Daftar Banner</h1>
                <p class="text-gray-600 mt-1">Kelola informasi banner kantin</p>
            </div>

            <!-- Action Buttons -->
            <div class="mb-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari banner..."
                            class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau1 focus:border-hijau1 text-sm"
                            onkeyup="searchTable()">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <a href="{{ route('banner.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-hijau1 text-white rounded-lg hover:bg-hijau1/90 transition-colors duration-150">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Tambah Banner</span>
                </a>
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

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banner</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kantin</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($banners as $banner)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex-shrink-0 h-20 w-32">
                                            <img src="{{ Storage::url($banner->gambar) }}" alt="{{ $banner->nama }}"
                                                class="h-20 w-32 rounded object-cover" loading="lazy">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $banner->nama }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('banner.edit', $banner->id) }}"
                                            class="inline-flex items-center px-3 py-2 text-blue-600 hover:text-blue-900 mr-3 transition-colors duration-150">
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </a>
                                        <form action="{{ route('banner.destroy', $banner->id) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus banner ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 text-red-600 hover:text-red-900 transition-colors duration-150">
                                                <i class="fas fa-trash mr-2"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="mt-4">
                        @if ($banners instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{ $banners->appends(request()->query())->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function searchTable() {
            const searchInput = document.getElementById('searchInput');
            const filter = searchInput.value.toLowerCase();
            const table = document.querySelector('table');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
                const nameCell = rows[i].getElementsByTagName('td')[1]; // Index 1 is the name column

                if (nameCell) {
                    const name = nameCell.textContent || nameCell.innerText;

                    if (name.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</x-app-layout>
