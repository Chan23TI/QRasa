<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Banner</h1>
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('banner.create') }}" class="inline-block bg-orenTua text-white px-4 py-2 rounded mb-4">
            Tambah Banner
        </a> <!-- Tombol untuk menambah banners -->

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($banners as $item)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($item->gambar) }}" class="w-full h-48 object-cover" alt="Gambar banners" />
                    <div class="p-4">
                        <h2 class="text-lg font-bold">{{ $item->nama }}</h2>
                        <div class="mt-4">
                            <a href="{{ route('banner.edit', $item->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('banner.destroy', $item->id) }}" method="POST" class="inline">
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
