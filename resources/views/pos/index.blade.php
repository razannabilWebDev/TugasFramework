<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Kasir</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded-md text-sm">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
            <div class="p-3 bg-red-100 text-red-700 rounded-md text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <x-card>
                <form action="{{ route('pos.store') }}" method="POST" id="pos-form" class="space-y-4">
                    @csrf

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Produk</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Harga</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Stok</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $product)
                            <tr class="@if ($product->stock == 0) bg-red-50 @endif">
                                <td class="px-4 py-2 text-sm">
                                    {{ $product->name }}
                                    <span class="text-gray-400 text-xs block">{{ $product->code }} &middot;
                                        {{ $product->category?->name }}</span>
                                </td>
                                <td class="px-4 py-2 text-sm text-right">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-sm text-center">{{ $product->stock }}</td>
                                <td class="px-4 py-2 text-sm text-center">
                                    <input type="hidden" name="items[{{ $loop->index }}][product_id]"
                                        value="{{ $product->id }}">
                                    <input type="number" name="items[{{ $loop->index }}][qty]" min="0" value="0"
                                        data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                                        class="qty-input w-20 rounded-md border-gray-300 text-center"
                                        @disabled($product->stock == 0)>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada produk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="flex flex-wrap items-end justify-end gap-4 border-t pt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total</label>
                            <p id="total" class="text-lg font-semibold">Rp0</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Uang Bayar</label>
                            <input type="number" name="pay" id="pay" min="0" value="{{ old('pay', 0) }}"
                                class="mt-1 block w-40 rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kembalian</label>
                            <p id="change" class="text-lg font-semibold">Rp0</p>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">
                            Proses Transaksi
                        </button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        (function () {
            const inputs = document.querySelectorAll('.qty-input');
            const totalEl = document.getElementById('total');
            const changeEl = document.getElementById('change');
            const payEl = document.getElementById('pay');

            const rupiah = (value) => 'Rp' + value.toLocaleString('id-ID');

            function recalc() {
                let total = 0;
                inputs.forEach((input) => {
                    total += (parseInt(input.value, 10) || 0) * (parseInt(input.dataset.price, 10) || 0);
                });

                const pay = parseInt(payEl.value, 10) || 0;
                totalEl.textContent = rupiah(total);
                changeEl.textContent = rupiah(Math.max(pay - total, 0));
            }

            inputs.forEach((input) => {
                input.addEventListener('input', () => {
                    const stock = parseInt(input.dataset.stock, 10) || 0;
                    const qty = parseInt(input.value, 10) || 0;

                    if (qty > stock) {
                        input.value = stock;
                    }

                    recalc();
                });
            });

            payEl.addEventListener('input', recalc);
            recalc();
        })();
    </script>
    @endpush
</x-app-layout>
