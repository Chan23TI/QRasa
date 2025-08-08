<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter bg-orange-50 selection:bg-cyan-500 selection:text-white">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-600 dark:hover:text-slate-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Login</a>
                @endauth
            </div>
        @endif

        <div class=" max-h-full max-w-sm mx-auto p-6 bg-orange-200 rounded-3xl shadow-md text-center mb-2">
            <div class="flex justify-center items-center">
                <img src="{{ asset('img/Nasi Padang Photography.jpg') }}"
                     class="w-full max-w-xs rounded-lg object-cover"
                     alt="Nasi Padang">
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-2 py-2">QRASA</h1>
            <p class="text-sm text-gray-600 mb-4">
                Akses Menu cepat dengan QR RASA!
            </p>
            <p class="text-md text-gray-800 mb-4">Scan QR Code</p>

            <!-- 🔘 Tombol kamera -->
            <button id="scanBtn" class="w-14 h-14 bg-cream rounded-full mx-auto flex items-center justify-center shadow-md">
                <img src="{{ asset('/img/Cameraa.png') }}" class="h-10 w-10 text-gray-800">
            </button>

            <!-- 📷 Tempat scanner muncul -->
            <div id="reader" style="width: 300px; margin: 20px auto;"></div>
        </div>
    </div>

    <style>
        .bg-cream {
            background-color: white;
        }
    </style>

    <!-- ✅ Tambah script HTML5 QR Code -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <!-- ✅ Tambah script JS untuk aktifkan kamera saat tombol ditekan -->
    <script>
        const cameraButton = document.getElementById('scanBtn');

        cameraButton.addEventListener('click', () => {
            const html5QrCode = new Html5Qrcode("reader");

            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length) {
                    const cameraId = cameras[0].id;

                    html5QrCode.start(
                        cameraId,
                        {
                            fps: 10,
                            qrbox: 250
                        },
                        (decodedText, decodedResult) => {
                            console.log(`QR hasil: ${decodedText}`);

                            html5QrCode.stop().then(() => {
                                // Redirect ke menu sambil bawa hasil QR (contoh token)
                                window.location.href = `/menu?token=${encodeURIComponent(decodedText)}`;
                            });
                        },
                        (errorMessage) => {
                            console.warn(`QR error: ${errorMessage}`);
                        }
                    );
                }
            }).catch(err => {
                console.error(`Camera error: ${err}`);
            });
        });
    </script>
</body>
</html>
