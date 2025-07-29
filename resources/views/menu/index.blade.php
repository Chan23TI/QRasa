<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <nav
            class="bg-putih p-4 mb-4 shadow rounded text-gray-500 flex flex-col md:flex-row md:justify-between md:items-center gap-2">
            <div class="font-bold text-lg">
                {{ $selectedBanner ? $selectedBanner->nama : 'Semua Kantin' }}
            </div>

            <form action="{{ route('menu.index') }}" method="GET" class="relative w-full md:w-auto">
                <select name="banner_id" onchange="this.form.submit()"
                    class="block  w-full appearance-none bg-white text-gray-800 border border-gray-300 px-4 py-2 pr-10 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <option value="">Semua Kantin</option>
                    @foreach ($banners as $banner)
                        <option value="{{ $banner->id }}" {{ request('banner_id') == $banner->id ? 'selected' : '' }}>
                            {{ $banner->nama }}
                        </option>
                    @endforeach
                </select>
            </form>
        </nav>


        <h1 class="text-2xl font-bold mb-4">Daftar Menu</h1>
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('menu.create') }}" class="inline-block bg-orenTua text-white px-4 py-2 rounded">
                Tambah Menu
            </a>
            
            <div class="relative w-72">
                <input type="text" id="searchInput" placeholder="Cari menu..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-hijau1 focus:border-hijau1"
                    onkeyup="searchTable()">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Menu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diskon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($menu as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex-shrink-0 h-20 w-20">
                                    <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->nama }}"
                                         class="h-20 w-20 rounded object-cover">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">
                                    {!! Str::limit($item->deskripsi, 100) !!}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    Rp{{ number_format($item->harga, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->kategori }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->stok }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->diskon }}%</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('menu.edit', $item->id) }}"
                                   class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <form action="{{ route('menu.destroy', $item->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>

    <script>
        function searchTable() {
            const searchInput = document.getElementById('searchInput');
            const filter = searchInput.value.toLowerCase();
            const table = document.querySelector('table');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
                const nameCell = rows[i].getElementsByTagName('td')[1]; // Index 1 is the name column
                const descCell = rows[i].getElementsByTagName('td')[2]; // Index 2 is the description column
                const categoryCell = rows[i].getElementsByTagName('td')[4]; // Index 4 is the category column
                
                if (nameCell && descCell && categoryCell) {
                    const name = nameCell.textContent || nameCell.innerText;
                    const description = descCell.textContent || descCell.innerText;
                    const category = categoryCell.textContent || categoryCell.innerText;
                    
                    if (name.toLowerCase().indexOf(filter) > -1 || 
                        description.toLowerCase().indexOf(filter) > -1 ||
                        category.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</x-app-layout>

