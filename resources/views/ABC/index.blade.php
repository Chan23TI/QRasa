<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Daftar About</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol tambah / edit -->
        @if ($ABC->count() > 0)
            <a href="{{ route('ABC.edit', $ABC->first()->id) }}"
               class="inline-block bg-red-600 text-white px-4 py-2 rounded mb-4">Edit About</a>
        @else
            <a href="{{ route('ABC.create') }}"
               class="inline-block bg-red-600 text-white px-4 py-2 rounded mb-4">Tambah About</a>
        @endif

        <!-- List About -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            @foreach ($ABC as $item)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    @if ($item->gambar)
                        <img src="{{ Storage::url($item->gambar) }}" class="w-full h-48 object-cover" alt="Gambar About" />
                    @endif

                    <div class="p-4">
                        <h2 class="text-lg font-bold">{{ $item->judul }}</h2>
                        <p class="text-gray-600 mt-2">{{ $item->isi }}</p>

                        <form action="{{ route('ABC.destroy', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline mt-2 inline-block">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
