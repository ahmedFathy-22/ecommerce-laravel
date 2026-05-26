<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Admin Dashboard
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Welcome back 👋
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

                <!-- Orders -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border border-gray-100 dark:border-gray-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-gray-500">
                                Total Orders
                            </p>

                            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                                {{ $orders }}
                            </h3>
                        </div>

                        <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-xl">
                            📦
                        </div>

                    </div>

                </div>

                <!-- Revenue -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border border-gray-100 dark:border-gray-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-gray-500">
                                Revenue
                            </p>

                            <h3 class="text-3xl font-bold text-green-500 mt-2">
                                ${{ number_format($revenue, 2) }}
                            </h3>
                        </div>

                        <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-xl">
                            💰
                        </div>

                    </div>

                </div>

                <!-- Products -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border border-gray-100 dark:border-gray-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-gray-500">
                                Products
                            </p>

                            <h3 class="text-3xl font-bold text-purple-500 mt-2">
                                {{ $products }}
                            </h3>
                        </div>

                        <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-xl">
                            🛒
                        </div>

                    </div>

                </div>

                <!-- Users -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border border-gray-100 dark:border-gray-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-gray-500">
                                Users
                            </p>

                            <h3 class="text-3xl font-bold text-orange-500 mt-2">
                                {{ $users }}
                            </h3>
                        </div>

                        <div class="bg-orange-100 dark:bg-orange-900/30 p-3 rounded-xl">
                            👤
                        </div>

                    </div>

                </div>

            </div>

            <!-- Charts + Products -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-8">

                <!-- Chart -->
                <div
                    class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border border-gray-100 dark:border-gray-700">

                    <div class="flex items-center justify-between mb-6">

                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                                Monthly Sales
                            </h3>

                            <p class="text-sm text-gray-500">
                                Revenue overview
                            </p>
                        </div>

                    </div>

                    <div class="h-[350px]">
                        <canvas id="salesChart"></canvas>
                    </div>

                </div>

                <!-- Top Products -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border border-gray-100 dark:border-gray-700">

                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">
                        🔥 Top Products
                    </h3>

                    <div class="space-y-4">

                        @foreach ($topProducts as $product)
                            <div
                                class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">

                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-white">
                                        {{ $product->name }}
                                    </h4>

                                    <p class="text-sm text-gray-500">
                                        {{ $product->order_items_count }}
                                    </p>
                                </div>

                                <div class="text-green-500 font-bold">
                                    #
                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('salesChart');

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: {!! json_encode($monthlySales->keys()->map(fn($month) => date('M', mktime(0, 0, 0, $month, 1)))) !!},

                datasets: [{

                    label: 'Revenue',

                    data: {!! json_encode($monthlySales->values()) !!},

                    borderRadius: 10,

                    backgroundColor: '#3B82F6',

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {
                        beginAtZero: true
                    }

                }

            }

        });
    </script>

</x-app-layout>
