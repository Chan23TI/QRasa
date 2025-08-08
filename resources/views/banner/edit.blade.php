<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        <x-admin-sidebar />

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Edit Banner</h1>
                        <p class="text-gray-600 mt-1">Perbarui informasi kantin di bawah ini</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('banner.index') }}"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-hijau1">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden max-w-4xl">
                <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Image Preview -->
                    <div class="w-full mb-6">
                        <div class="relative aspect-video rounded-lg overflow-hidden bg-gray-100 mb-4">
                            <img id="image-preview" src="{{ Storage::url($banner->gambar) }}" alt="Preview"
                                class="w-full h-full object-cover">
                            <div id="image-placeholder"
                                class="absolute inset-0 items-center justify-center text-gray-400 hidden">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        </div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Banner
                        </label>
                        <input type="file" name="gambar" id="gambar" accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau1 focus:border-hijau1 text-sm"
                            onchange="previewImage(this)">
                        @error('gambar')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Kantin -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kantin</label>
                        <input type="text" name="nama" value="{{ old('nama', $banner->nama) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hijau1 focus:border-hijau1">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 pt-6">
                        <a href="{{ route('banner.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-150">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-hijau1 hover:bg-hijau1/90 rounded-lg transition-colors duration-150">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('image-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>