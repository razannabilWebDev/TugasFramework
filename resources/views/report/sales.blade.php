<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Laporan Penjualan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <x-card>
                    <p class="text-sm text-gray-500">Jumlah Transaksi</p>
                    <p class="text-2xl font-semibold">{{ number_format($summary['transactions'], 0, ',', '.') }}</p>
                </x-card>
                <x-card>
                    <p class="text-sm text-gray-500">Total Omzet</p>
                    <p class="text-2xl font-semibold">Rp{{ number_format($summary['revenue'], 0, ',', '.') }}</p>
                </x-card>
                <x-card>
                    <p class="text-sm text-gray-500">Item Terjual</p>
                    <p class="text-2xl font-semibold">{{ number_format($summary['items_sold'], 0, ',', '.') }}</p>
                </x-card>
            </div>

            <x-card>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Kode</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Produk</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Terjual</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-2 text-sm">{{ $product->code }}</td>
                            <td class="px-4 py-2 text-sm">{{ $product->name }}</td>
                            <td class="px-4 py-2 text-sm text-center">
                                {{ number_format($product->qty_sold, 0, ',', '.') }} {{ $product->unit }}
                            </td>
                            <td class="px-4 py-2 text-sm text-right">
                                Rp{{ number_format($product->revenue, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
