<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Daftar About</h1>
       @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol untuk menambah menu -->
        @if ($ABC->count() > 0)
            {{-- Akses data pertama untuk ID --}}
            <a href="{{ route('ABC.edit', $ABC->first()->id) }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded mb-4">Edit About</a>
        @else
            {{-- Jika tidak ada data --}}
            <a href="{{ route('ABC.create') }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded mb-4">Tambah About</a>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            @foreach ($ABC as $item)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($item->gambar1) }}" class="w-full h-48 object-cover" alt="Gambar About" />

                    <div class="p-4">
                        <p class="text-gray-600 mt-2">{{ $item->isi }}</p>
                        <img src="{{ Storage::url($item->gambar2) }}" class="w-full h-48 object-cover" alt="Gambar About" />
                            <form action="{{ route('ABC.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
