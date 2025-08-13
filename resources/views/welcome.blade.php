<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QRASA - Landing Page</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-orange-50">

    <!-- 🔹 Navbar -->
    <nav class="flex justify-between items-center p-6 bg-white shadow">
        <div class="text-2xl font-bold text-orange-600">QRASA</div>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/login') }}" class="text-gray-600 hover:text-orange-600">Login</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-800 font-semibold hover:text-orange-600">Login</a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- 🔹 Hero Section -->
    <section class="relative bg-white">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center px-6 py-16 lg:py-20">

            <!-- Text -->
            <div class="flex-1 mb-10 lg:mb-0">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 leading-tight">
                    @if($ABC) {{ $ABC->judul }} @else Personalized Catering <br> Made Just For You @endif
                </h1>
                <p class="mt-4 text-gray-600 text-lg">
                    @if($ABC) {{ $ABC->isi }} @else Akses menu cepat, praktis, dan higienis dengan QRASA.
                    Cukup scan dan nikmati pengalaman baru memesan makanan! @endif
                </p>
                <button id="scanBtn" class="mt-6 inline-block bg-orange-500 text-white px-6 py-3 rounded-lg shadow hover:bg-orange-600 transition">
                    Scan QR mu!!
                </button>

                <!-- 📷 Tempat scanner (hidden) -->
                <div id="reader" style="width: 300px; margin-top: 20px; display:none;"></div>
            </div>

            <!-- Image -->
           <div class="flex-1 flex justify-center">
    @if($ABC && $ABC->gambar)
        <img src="{{ asset('storage/'.$ABC->gambar) }}" alt="Catering"
             class="rounded-3xl shadow-lg"
             style="width: 600px; height: 265px; object-fit: cover;">
    @else
        <img src="{{ asset('img/hero-food.jpg') }}" alt="Catering"
             class="rounded-3xl shadow-lg"
             style="width: 600px; height: 200px; object-fit: cover;">
    @endif
</div>

        </div>
    </section>

    <!-- ✅ Script QR Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const cameraButton = document.getElementById('scanBtn');
        cameraButton.addEventListener('click', () => {
            document.getElementById('reader').style.display = 'block'; // Tampilkan scanner
            const html5QrCode = new Html5Qrcode("reader");
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length) {
                    const cameraId = cameras[0].id;
                    html5QrCode.start(
                        cameraId,
                        { fps: 10, qrbox: 250 },
                        (decodedText) => {
                            html5QrCode.stop().then(() => {
                                window.location.href = `/menu?token=${encodeURIComponent(decodedText)}`;
                            });
                        },
                        (errorMessage) => { console.warn(`QR error: ${errorMessage}`); }
                    );
                }
            }).catch(err => { console.error(`Camera error: ${err}`); });
        });
    </script>

    <!-- 🔹 Contact Section -->
<section class="bg-orange-100 py-10">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Hubungi Kami</h2>

        @if($contact)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @if($contact->wa)
                    <a href="https://wa.me{{ preg_replace('/[^0-9]/', '', $contact->wa) }}"
                       target="_blank"
                       class="bg-white shadow rounded-lg p-4 hover:shadow-lg transition">
                        <img src="https://www.bing.com/th/id/OIP.yUh4S-UUK_f3GJSq3J-q8QHaHa?w=170&h=211&c=8&rs=1&qlt=90&r=0&o=6&cb=thwsc4&dpr=1.4&pid=3.1&rm=2" alt="WhatsApp" class="h-8 mx-auto mb-2">
                        <span class="text-gray-700">{{ $contact->wa }}</span>
                    </a>
                @endif

                @if($contact->ig)
                    <a href="https://instagram.com/{{ ltrim($contact->ig, '@') }}"
                       target="_blank"
                       class="bg-white shadow rounded-lg p-4 hover:shadow-lg transition">
                        <img src="https://tse2.mm.bing.net/th/id/OIP.eLntIxf-IiUiCvYXfvutfgHaHw?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Instagram" class="h-8 mx-auto mb-2">
                        <span class="text-gray-700">{{ $contact->ig }}</span>
                    </a>
                @endif

                @if($contact->fb)
                    <a href="{{ $contact->fb }}"
                       target="_blank"
                       class="bg-white shadow rounded-lg p-4 hover:shadow-lg transition">
                        <img src="https://tse3.mm.bing.net/th/id/OIP.ECzNbQR_AZfAJQfBPXjMGgHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Facebook" class="h-8 mx-auto mb-2">
                        <span class="text-gray-700">Facebook</span>
                    </a>
                @endif

                @if($contact->email)
                    <a href="mailto:{{ $contact->email }}"
                       class="bg-white shadow rounded-lg p-4 hover:shadow-lg transition">
                        <img src="https://tse1.mm.bing.net/th/id/OIP.TW21b-CFGudjWw39HNhqcgHaEK?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Email" class="h-8 mx-auto mb-2">
                        <span class="text-gray-700">{{ $contact->email }}</span>
                    </a>
                @endif
            </div>
        @else
            <p class="text-gray-500">Kontak belum tersedia.</p>
        @endif
    </div>
</section>

</body>
</html>
