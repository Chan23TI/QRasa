<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        <x-admin-sidebar />

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Tambah Menu Baru</h1>
                        <p class="text-gray-600 mt-1">Isi form di bawah untuk menambah menu baru</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('menu.index') }}"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-hijau1">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden max-w-4xl">
                <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Nama menu</label>
                <input type="text" name="nama" class="mt-1 block w-full border-gray-300 rounded-md" required />
                @error('nama')
                    <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Deskripsi</label>
                <textarea name="deskripsi" id="editor" rows="5" class="mt-1 block w-full border-gray-300 rounded-md" required></textarea>
                @error('deskripsi')
                    <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Diskon</label>
                <input type="text" name="diskon" class="mt-1 block w-full border-gray-300 rounded-md" required />
                @error('diskon')
                    <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Kategori</label>
                <input type="text" name="kategori" class="mt-1 block w-full border-gray-300 rounded-md" required />
                @error('kategori')
                    <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Stok</label>
                <input type="text" name="stok" class="mt-1 block w-full border-gray-300 rounded-md" required />
                @error('stok')
                    <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Harga</label>
                <input type="text" name="harga" class="mt-1 block w-full border-gray-300 rounded-md" required />
                @error('harga')
                    <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Gambar</label>
                <input type="file" name="gambar" class="mt-1 block w-full" accept="image/*" />
                @error('gambar')
                    <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="banner_id" class="block text-sm font-medium">Pilih Kantin</label>
                <select name="banner_id" id="banner_id" class="form-select mt-1 block rounded">
                    @foreach ($banners as $banner)
                        <option value="{{ $banner->id }}">{{ $banner->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-orenTua text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    // Update the textarea value when the content changes
                    document.querySelector('textarea[name="isi_menu"]').value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
