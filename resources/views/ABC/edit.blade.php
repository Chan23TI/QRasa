<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Edit About</h1>

        <form action="{{ route('ABC.update', $ABC->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $ABC->judul) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md" required>
                @error('judul')
                    <span class="text-red-700 py-2 rounded">{{ $message }}</span>
                @enderror
            </div>

            <!-- Isi -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Isi</label>
                <textarea name="isi" id="editor" rows="5"
                          class="mt-1 block w-full border-gray-300 rounded-md">{{ old('isi', $ABC->isi) }}</textarea>
                @error('isi')
                    <span class="text-red-700 py-2 rounded">{{ $message }}</span>
                @enderror
            </div>

            <!-- Gambar -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Gambar</label>
                <input type="file" name="gambar" class="mt-1 block w-full" accept="image/*" />
                @if ($ABC->gambar)
                    <img src="{{ Storage::url($ABC->gambar) }}" class="h-48 mt-2 rounded-lg shadow" alt="Gambar About" />
                @endif
                @error('gambar')
                    <span class="text-red-700 py-2 rounded">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Update -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
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
