<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <img src="/img/asset1.png" alt="asset" class="w-52 absolute top-0 right-0 rotate-180 mt-16">
        <img src="/img/asset1.png" alt="asset" class="w-52 fixed bottom-0 left-0">
        <h1 class="text-2xl font-bold mb-4">Tambah About</h1>
        <form action="{{ route('ABC.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Isi About Paragraf 1</label>
                <textarea name="isi" id="editor" rows="5" class="mt-1 block w-full border-gray-300 rounded-md" required></textarea>
                @error('isi')
                <span class="text-red-700  py-2 rounded">{{  $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Gambar</label>
                <input type="file" name="gambar1" class="mt-1 block w-full" accept="image/*" />
                @error('gambar1')
                <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
            </div>


            <div class="mb-4">
                <label class="block text-sm font-medium">Gambar</label>
                <input type="file" name="gambar2" class="mt-1 block w-full" accept="image/*" />
                @error('gambar2')
                <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    // Update the textarea value when the content changes
                    document.querySelector('textarea[name="isi_about"]').value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
