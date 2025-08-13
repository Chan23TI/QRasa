<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        <x-admin-sidebar />
        <main class="flex-1 ml-64 p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">
                        Daftar Pesanan Anda
                    </h1>
                    <p class="text-gray-600 mt-1">Kelola pesanan anda dengan mudah</p>
                </div>

                <form action="{{ route('pesan.index') }}" method="GET" class="mb-4 flex items-center space-x-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Filter Status:</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-hijau1 focus:border-hijau1 sm:text-sm rounded-md">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $statusOption)
                                <option value="{{ $statusOption }}"
                                    {{ request('status') == $statusOption ? 'selected' : '' }}>
                                    {{ ucfirst($statusOption) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Filter Metode
                            Pembayaran:</label>
                        <select name="payment_method" id="payment_method"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-hijau1 focus:border-hijau1 sm:text-sm rounded-md">
                            <option value="">Semua Metode Pembayaran</option>
                            @foreach ($paymentMethods as $methodOption)
                                <option value="{{ $methodOption }}"
                                    {{ request('payment_method') == $methodOption ? 'selected' : '' }}>
                                    {{ ucfirst($methodOption) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="mt-5 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-hijau1 hover:bg-hijau1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Filter
                    </button>
                    @if (request()->has('status') || request()->has('payment_method'))
                        <a href="{{ route('pesan.index') }}"
                            class="mt-5 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Reset Filter
                        </a>
                    @endif
                </form>
            </div>

            <div class="py-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">

                            @if ($pesans->isEmpty())
                                <p>Anda belum memiliki pesanan.</p>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    ID Pesanan
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Total
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status & Pembayaran
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Metode Pembayaran
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nomor Meja
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Menu Dipesan
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Tanggal Pesan
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($pesans as $pesan)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $pesan->id }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        Rp{{ number_format($pesan->total, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{-- Status Pesan --}}
                                                        <div>
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                @if ($pesan->status == 'belum diantar') bg-red-100 text-red-800
                                                                @elseif($pesan->status == 'sudah diantar')
                                                                    bg-green-100 text-green-800
                                                                @else
                                                                    bg-yellow-100 text-yellow-800 @endif
                                                                ">
                                                                {{ ucfirst($pesan->status) }}
                                                            </span>
                                                        </div>
                                                        {{-- Status Pembayaran --}}
                                                        <div class="mt-1">
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                @if ($pesan->status_pembayaran == 'sudah dibayar') bg-green-100 text-green-800
                                                                @elseif($pesan->status_pembayaran == 'pending')
                                                                    bg-yellow-100 text-yellow-800
                                                                @else
                                                                    bg-red-100 text-red-800 @endif
                                                                ">
                                                                {{ ucfirst($pesan->status_pembayaran ?? 'belum dibayar') }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ ucfirst($pesan->payment_method) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $pesan->meja ? $pesan->meja->nomor_meja : '-' }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        @foreach ($pesan->menus as $menu)
                                                            <div class="flex items-center mb-2">
                                                                <img src="{{ asset('storage/' . $menu->gambar) }}"
                                                                    alt="{{ $menu->nama }}"
                                                                    class="w-10 h-10 object-cover rounded-md mr-2">
                                                                <div>
                                                                    <p class="text-sm font-medium text-gray-900">
                                                                        {{ $menu->nama }}</p>
                                                                    <p class="text-xs text-gray-500">
                                                                        ({{ $menu->pivot->quantity }}x)
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $pesan->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap space-y-2">
                                                        @if ($pesan->status === 'belum diantar')
                                                            <form action="{{ route('pesan.updateStatus', $pesan) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                    Sudah Diantar
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if ($pesan->status_pembayaran === 'belum dibayar' || $pesan->status_pembayaran === null)
                                                            <form action="{{ route('pesan.updateStatusPembayaran', $pesan) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                    Sudah Dibayar
                                                                </button>
                                                            </form>
                                                        @elseif ($pesan->status_pembayaran === 'pending')
                                                            <form action="{{ route('pesan.updateStatusPembayaran', $pesan) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                    Tandai Lunas
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $pesans->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
