<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <img src="/img/asset1.png" alt="asset" class="w-52 absolute top-0 right-0 rotate-180 mt-16">
        <img src="/img/asset1.png" alt="asset" class="w-52 fixed bottom-0 left-0">

        <h1 class="text-2xl font-bold mb-4">Tambah About</h1>

        <form action="{{ route('ABC.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Judul -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                @error('judul')
                    <span class="text-red-700 py-2 rounded">{{ $message }}</span>
                @enderror
            </div>

            <!-- Isi -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Isi</label>
                <textarea name="isi" rows="3" class="mt-1 block w-full border-gray-300 rounded-md" required>{{ old('isi') }}</textarea>
                @error('isi')
                    <span class="text-red-700 py-2 rounded">{{ $message }}</span>
                @enderror
            </div>

            <!-- Gambar -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Gambar</label>
                <input type="file" name="gambar" class="mt-1 block w-full" accept="image/*" />
                @error('gambar')
                    <span class="text-red-700 py-2 rounded">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>
