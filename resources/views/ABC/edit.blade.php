<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        {{-- <img src="/img/asset1.png" alt="asset" class="w-52 absolute top-0 right-0 rotate-180 mt-16">
        <img src="/img/asset1.png" alt="asset" class="w-52 fixed bottom-0 left-0"> --}}
        <h1 class="text-2xl font-bold mb-4">Edit About</h1>

            <form action="{{ route('ABC.update', $ABC->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium">Isi About Paragraf 1</label>
                    <textarea name="isi" id="editor" rows="5" class="mt-1 block w-full border-gray-300 rounded-md">{{ $ABC->isi }}</textarea>
                    @error('isi')
                        <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="mb-4">
                    <label class="block text-sm font-medium">Isi About Paragraf 2</label>
                    <textarea name="isidua" id="editor" rows="5" class="mt-1 block w-full border-gray-300 rounded-md">{{ $aboutUs->isidua }}</textarea>
                    @error('isidua')
                        <span class="text-red-700  py-2 rounded">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div class="mb-4">
                    <label class="block text-sm font-medium">Gambar</label>
                    <input type="file" name="gambar1" class="mt-1 block w-full" accept="image/*" />
                    @if ($ABC->gambar1)
                        <img src="{{ Storage::url($ABC->gambar1) }}" class="h-48 mt-2" alt="Gambar Promo" />
                    @endif
                    @error('gambar1')
                        <span class="text-red-700 py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Gambar</label>
                    <input type="file" name="gambar2" class="mt-1 block w-full" accept="image/*" />
                    @if ($ABC->gambar2)
                        <img src="{{ Storage::url($ABC->gambar2) }}" class="h-48 mt-2" alt="Gambar Promo" />
                    @endif
                    @error('gambar2')
                        <span class="text-red-700 py-2 rounded">{{ $message }}</span>
                    @enderror
                </div>
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
