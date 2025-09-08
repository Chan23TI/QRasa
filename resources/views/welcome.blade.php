<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QRasa - Akses Menu Cepat</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('img/Logo/LogoKantin.png') }}"/>
    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                   <span class="text-3xl font-black tracking-tight text-orange-600">QRasa</span>
                </a>
            </div>
            <div class="flex lg:flex-1 lg:justify-end">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/menu') }}" class="text-sm font-semibold leading-6 text-gray-900">Home <span aria-hidden="true">&rarr;</span></a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <div class="relative isolate overflow-hidden bg-gradient-to-b from-orange-100/20 pt-14">
            <div class="absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] bg-white shadow-xl shadow-orange-600/10 ring-1 ring-orange-50 sm:-mr-80 lg:-mr-96" aria-hidden="true"></div>
            <div class="mx-auto max-w-7xl px-6 py-32 sm:py-40 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0 lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-x-16 lg:gap-y-6 xl:grid-cols-1 xl:grid-rows-1 xl:gap-x-8">
                    <h1 class="max-w-2xl text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl lg:col-span-2 xl:col-auto">
                        Selamat Datang di QRasa! <br class="hidden sm:inline lg:hidden">
                    </h1>
                    <div class="mt-6 max-w-xl lg:mt-0 xl:col-end-1 xl:row-start-1">
                        <p class="text-lg leading-8 text-gray-600">
                            Akses menu cepat, praktis, dan higienis. Cukup pindai kode QR di meja Anda dan nikmati pengalaman baru memesan makanan tanpa antre!
                        </p>
                        <div class="mt-10 flex items-center gap-x-6">
                            <a href="#scanner" class="rounded-md bg-orange-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">
                                Pindai QR Sekarang
                            </a>
                        </div>
                    </div>
                    <img src="{{ asset('img/Suasana Kantin Kampus.png') }}" alt="Suasana Kantin" class="mt-10 w-full max-w-lg rounded-2xl object-cover sm:mt-16 lg:mt-0 lg:max-w-none xl:row-span-2 xl:row-end-2 xl:mt-36">
                </div>
            </div>
            <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-white sm:h-32"></div>
        </div>

        <!-- QR Scanner Section -->
        <div id="scanner" class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl sm:text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Pindai Kode QR</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Arahkan kamera Anda ke kode QR yang ada di meja untuk melihat menu dan memesan.
                    </p>
                </div>
                <div class="mx-auto mt-16 max-w-sm rounded-3xl bg-orange-50 p-6 text-center shadow-lg ring-1 ring-inset ring-orange-900/5 lg:p-8">
                    <div id="reader" class="w-full rounded-lg"></div>
                    <button id="scanBtn" class="mt-6 w-full rounded-md bg-orange-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600 flex items-center justify-center gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.776 48.776 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                        Buka Kamera
                    </button>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gradient-to-r from-orange-500 to-orange-600" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="mx-auto max-w-7xl px-6 pb-8 pt-12 sm:pt-16 lg:px-8">
            <div class="md:flex md:justify-between">
                <div class="space-y-8">
                    <img class="h-12 w-auto rounded-xl" src="{{ asset('img/Logo/LogoKantin.png') }}" alt="QRASA">
                    <p class="text-sm leading-6 text-orange-50">Akses menu cepat, praktis, dan higienis. <br> Nikmati pengalaman baru memesan tanpa antre.</p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-white hover:text-orange-100">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" class="text-white hover:text-orange-100">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.013-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.08 2.525c.636-.247 1.363.416 2.427-.465C9.53 2.013 9.885 2 12.315 2zM12 7a5 5 0 100 10 5 5 0 000-10zm0 8a3 3 0 110-6 3 3 0 010 6zm6.406-11.845a1.25 1.25 0 100 2.5 1.25 1.25 0 000-2.5z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" class="text-white hover:text-orange-100">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                        </a>
                    </div>
                </div>
                <div class="mt-16 grid grid-cols-2 gap-8 md:mt-0">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">Navigasi</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li><a href="#" class="text-sm leading-6 text-orange-50 hover:text-white">Beranda</a></li>
                                <li><a href="#scanner" class="text-sm leading-6 text-orange-50 hover:text-white">Scanner</a></li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">Lainnya</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li><a href="#" class="text-sm leading-6 text-orange-50 hover:text-white">Tentang Kami</a></li>
                                <li><a href="#" class="text-sm leading-6 text-orange-50 hover:text-white">Kontak</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" border-t border-putih/50 pt-8 sm:mt-16 lg:mt-20">
                <p class="text-xs leading-5 text-orange-100">&copy; 2025 QRASA. All rights reserved.</p>
            </div>
        </div>
    </footer>


    <!-- QR Scanner Script -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const cameraButton = document.getElementById('scanBtn');
        const readerDiv = document.getElementById('reader');

        cameraButton.addEventListener('click', () => {
            // Hide the button and show the reader
            cameraButton.style.display = 'none';
            readerDiv.style.display = 'block';

            const html5QrCode = new Html5Qrcode("reader");
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length) {
                    const cameraId = cameras[0].id;
                    html5QrCode.start(
                        cameraId,
                        { fps: 10, qrbox: { width: 250, height: 250 } },
                        (decodedText, decodedResult) => {
                            // Stop scanning and redirect
                            html5QrCode.stop().then(() => {
                                // Construct the URL safely
                                const url = new URL('/menu', window.location.origin);
                                url.searchParams.append('token', decodedText);
                                window.location.href = url.toString();
                            }).catch(err => console.error("Failed to stop QR code scanner.", err));
                        },
                        (errorMessage) => {
                            // This callback is called when a QR code is not found.
                            // You can choose to do nothing here or log for debugging.
                            // console.warn(`QR error: ${errorMessage}`);
                        }
                    ).catch(err => {
                        console.error(`Unable to start scanning, error: ${err}`);
                        alert(`Error: Tidak dapat memulai kamera. Pastikan Anda memberikan izin kamera.`);
                        // Show the button again if scanning fails to start
                        cameraButton.style.display = 'flex';
                        readerDiv.style.display = 'none';
                    });
                } else {
                    console.error("No cameras found.");
                    alert("Error: Tidak ada kamera yang ditemukan.");
                }
            }).catch(err => {
                console.error(`Camera permission error: ${err}`);
                alert("Error: Izin kamera ditolak. Mohon izinkan akses kamera untuk memindai QR code.");
            });
        });

        // Initially hide the reader
        readerDiv.style.display = 'none';
    </script>

</body>
</html>
