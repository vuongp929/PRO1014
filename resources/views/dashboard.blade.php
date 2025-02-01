<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Quản lý</h3>
                    <div class="space-x-4">
                        <!-- Nút Quản lý Sản phẩm -->
                        <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                            Quản lý Sản phẩm
                        </a>
                
                        <!-- Nút Quản lý Người dùng -->
                        <a href="{{ route('users.index') }}" class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                            Quản lý Người dùng
                        </a>
                
                        <!-- Nút Quản lý Đơn hàng -->
                        <a href="{{ route('orders.index') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-300">
                            Quản lý Đơn hàng
                        </a>
                    </div>
                </div>
                
                <!-- Tổng doanh thu -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tổng doanh thu</h3>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                        {{ number_format($revenue, 0, ',', '.') }} VNĐ
                    </p>
                </div>

                <!-- Tổng số đơn hàng -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tổng số đơn hàng</h3>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $ordersCount }}</p>
                </div>

                <!-- Tổng số sản phẩm -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tổng số sản phẩm</h3>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $productsCount }}</p>
                </div>
            </div>

            <!-- Biểu đồ -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Biểu đồ doanh thu theo tháng</h3>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar', // Hoặc 'line' để hiển thị dạng đường
            data: {
                labels: @json($months), // Nhãn các tháng
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: @json($monthlyRevenue), // Dữ liệu doanh thu theo tháng
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + ' VNĐ'; // Format tiền tệ
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>

