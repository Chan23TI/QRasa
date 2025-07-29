<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Edit Menu</h1>

            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium">Nama menu</label>
                    <input type="text" name="nama" value="{{ $menu->nama }}"
                        class="mt-1 block w-full border-gray-300 rounded-md" required />
                    @error('nama')
                        <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" id="editor" rows="5" class="mt-1 block w-full border-gray-300 rounded-md" required>{{ $menu->deskripsi }}</textarea>
                    @error('deskripsi')
                        <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Diskon</label>
                    <input type="text" name="diskon" value="{{ $menu->diskon }}"
                        class="mt-1 block w-full border-gray-300 rounded-md" required />
                    @error('diskon')
                        <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Kategori</label>
                    <input type="text" name="kategori" value="{{ $menu->kategori }}"
                        class="mt-1 block w-full border-gray-300 rounded-md" required />
                    @error('kategori')
                        <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Stok</label>
                    <input type="text" name="stok" value="{{ $menu->stok }}"
                        class="mt-1 block w-full border-gray-300 rounded-md" required />
                    @error('stok')
                        <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Harga</label>
                    <input type="text" name="harga" value="{{ $menu->harga }}"
                        class="mt-1 block w-full border-gray-300 rounded-md" required />
                    @error('harga')
                        <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Gambar</label>
                    <input type="file" name="gambar" class="mt-1 block w-full" accept="image/*" />
                    @if ($menu->gambar)
                        <img src="{{ Storage::url($menu->gambar) }}" class="h-48 mt-2" alt="Gambar menu" />
                    @endif
                    @error('gambar')
                        <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-orenTua text-white px-4 py-2 rounded">Update</button>
            </form>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
