<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Banner</h1>
        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Nama Banner</label>
                <input type="text" name="nama" class="mt-1 block w-full border-gray-300 rounded-md" required />
                @error('nama')
                <span class="text-red-700  py-2 rounded">{{  $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Gambar</label>
                <input type="file" name="gambar" class="mt-1 block w-full" accept="image/*" />
                @error('gambar')
                <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
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
                    document.querySelector('textarea[name="isi_Banner"]').value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
