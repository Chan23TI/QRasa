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

                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif --}}
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

                <button class="w-14 h-14 bg-cream rounded-full mx-auto flex items-center justify-center shadow-md">
                  <img src="{{ asset('/img/Cameraa.png') }}" class="h-10 w-10 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l1.5-1.5M21 8l-1.5-1.5M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 0013.586 4H10.414a1 1 0 00-.707.293L8.293 5.707A1 1 0 017.586 6H4a2 2 0 00-2 2v11a2 2 0 002 2z" />

                </button>
              </div>

              <style>
                .bg-cream {
                  background-color: white;
                }
              </style>
