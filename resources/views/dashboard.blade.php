<x-app-layout>
    <x-admin-sidebar />

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-8 bg-gray-50">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Penjualan</h1>
                <p class="text-gray-600 mt-1">Ringkasan dan statistik aplikasi Anda.</p>
            </div>
            <form action="{{ route('dashboard') }}" method="GET">
                <select name="period" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="today" @if($period == 'today') selected @endif>Hari Ini</option>
                    <option value="this_week" @if($period == 'this_week') selected @endif>Minggu Ini</option>
                    <option value="this_month" @if($period == 'this_month') selected @endif>Bulan Ini</option>
                </select>
            </form>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Penjualan -->
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-4">
                <div class="flex-shrink-0 bg-blue-100 text-blue-600 rounded-full p-3">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Penjualan</p>
                    <h2 class="text-2xl font-bold text-gray-800">Rp{{ number_format($revenue, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- Jumlah Pesanan -->
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-4">
                <div class="flex-shrink-0 bg-green-100 text-green-600 rounded-full p-3">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Pesanan</p>
                    <h2 class="text-2xl font-bold text-gray-800">{{ number_format($orders, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- Jumlah Menu -->
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-4">
                <div class="flex-shrink-0 bg-purple-100 text-purple-600 rounded-full p-3">
                    <i class="fas fa-utensils text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Jumlah Menu</p>
                    <h2 class="text-2xl font-bold text-gray-800">{{ number_format($totalMenus, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Grafik Penjualan</h3>
                    <form action="{{ route('dashboard') }}" method="GET">
                        <select name="chart_period" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="this_month" @if($chartPeriod == 'this_month') selected @endif>Bulan Ini</option>
                            <option value="this_year" @if($chartPeriod == 'this_year') selected @endif>Tahun Ini</option>
                            <option value="last_7_days" @if($chartPeriod == 'last_7_days') selected @endif>7 Hari Terakhir</option>
                            <option value="last_30_days" @if($chartPeriod == 'last_30_days') selected @endif>30 Hari Terakhir</option>
                        </select>
                    </form>
                </div>
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Isi top selling dan recent orders di sini -->
        </div>
    </main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('salesChart');
                if (ctx) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($chartData['labels']),
                            datasets: [{
                                label: 'Total Penjualan',
                                data: @json($chartData['data']),
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                fill: true
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
