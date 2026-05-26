<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div class="bg-blue-500 text-white p-4 rounded">
                            <h3 class="text-lg">Total Orders</h3>
                            <p class="text-2xl font-bold">{{ $orders }}</p>
                        </div>

                        <div class="bg-green-500 text-white p-4 rounded">
                            <h3 class="text-lg">Total Revenue</h3>
                            <p class="text-2xl font-bold">{{ $revenue }} $</p>
                        </div>

                        <div class="bg-purple-500 text-white p-4 rounded">
                            <h3 class="text-lg">Total Products</h3>
                            <p class="text-2xl font-bold">{{ $products }}</p>
                        </div>
                        <div class="card shadow p-5 mt-5">

                            <h3 class="mb-4">

                                🔥 Top Products

                            </h3>

                            @foreach ($topProducts as $product)
                                <div class="mb-3">

                                    {{ $product->name }}

                                    -

                                    {{ $product->order_items_count }}

                                    orders

                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="bg-gray-900 p-5 rounded mt-6">

                        <h3 class="text-xl mb-4 text-white">
                            Monthly Sales
                        </h3>

                        <div style="height:400px;">
                            <canvas id="salesChart"></canvas>
                        </div>



                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('salesChart');

        new Chart(ctx, {
            type: 'bar',

            data: {
                labels: {!! json_encode($monthlySales->keys()) !!},

                datasets: [{
                    label: 'Sales',

                    data: {!! json_encode($monthlySales->values()) !!},

                    backgroundColor: [
                        '#3B82F6',
                        '#10B981',
                        '#8B5CF6',
                        '#F59E0B',
                        '#EF4444',
                        '#EC4899',
                        '#14B8A6',
                        '#F97316',
                        '#6366F1',
                        '#84CC16',
                        '#06B6D4',
                        '#E11D48'
                    ],

                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

</x-app-layout>
