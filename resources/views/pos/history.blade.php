<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Riwayat Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">No. Invoice</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Kasir</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Item</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Total</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Bayar</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Kembalian</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($transactions as $transaction)
                        <tr>
                            <td class="px-4 py-2 text-sm">{{ $transaction->invoice_number }}</td>
                            <td class="px-4 py-2 text-sm">{{ $transaction->user?->name }}</td>
                            <td class="px-4 py-2 text-sm text-center">{{ $transaction->details_count }}</td>
                            <td class="px-4 py-2 text-sm text-right">
                                Rp{{ number_format($transaction->total, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-right">
                                Rp{{ number_format($transaction->pay, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-right">
                                Rp{{ number_format($transaction->change, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                Belum ada transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
