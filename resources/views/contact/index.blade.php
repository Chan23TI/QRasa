<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Kontak</h1>
    {{-- <img src="/img/asset1.png" alt="asset" class="w-52 absolute top-0 right-0 rotate-180 mt-16">
    <img src="/img/asset1.png" alt="asset" class="w-52 fixed bottom-0 left-0"> --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- <a href="{{ route('kontak.create') }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded mb-4">
            Tambah Kontak
        </a> <!-- Tombol untuk menambah review --> --}}

        @if ($contact->count() > 0)
            {{-- Akses data pertama untuk ID --}}
            <a href="{{ route('contact.edit', $contact->first()->id) }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded mb-4">Edit Kontak</a>
        @else
            {{-- Jika tidak ada data --}}
            <a href="{{ route('contact.create') }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded mb-4">Tambah Kontak</a>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            @foreach ($contact as $item)
                <div class="bg-white shadow-md rounded-lg overflow-hidden w-full ">
                    <div class="p-4">
                        <p class="text-gray-600 mt-2"><span><b>Nama instagram : </b></span>{{ $item->ig }}</p>
                        <p class="text-gray-600 mt-2"><span><b>Nomor whatsapp : </b></span>{{ $item->wa }}</p>
                        <p class="text-gray-600 mt-2"><span><b>Alamat email : </b></span>{{ $item->email }}</p>
                        <p class="text-gray-600 mt-2"><span><b>Facebook : </b></span>{{ $item->fb}}</p>
                        {{-- <p class="text-gray-600 mt-2"><span><b>Tahun Copyright : </b></span>{{ $item->tahun }}</p> --}}
                        <div class="mt-4">
                            <form action="{{ route('contact.destroy', $item->id) }}" method="POST" class="inline">
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
