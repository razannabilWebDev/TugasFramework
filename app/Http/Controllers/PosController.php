<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosController extends Controller
{
    /**
     * Halaman kasir: pilih produk dan jumlah, lalu bayar.
     */
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->get();

        return view('pos.index', compact('products'));
    }

    /**
     * Simpan transaksi dan kurangi stok produk.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'pay' => 'required|integer|min:0',
        ], [
            'items.required' => 'Keranjang masih kosong, pilih produk terlebih dahulu.',
        ]);

        try {
            $transaction = DB::transaction(function () use ($data) {
                $total = 0;
                $lines = [];

                foreach ($data['items'] as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                    $qty = (int) $item['qty'];

                    if ($product->stock < $qty) {
                        throw new \RuntimeException("Stok {$product->name} tidak mencukupi (tersisa {$product->stock}).");
                    }

                    $subtotal = $product->price * $qty;
                    $total += $subtotal;

                    $lines[] = [
                        'product' => $product,
                        'qty' => $qty,
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ];
                }

                if ($data['pay'] < $total) {
                    throw new \RuntimeException('Uang bayar kurang dari total belanja.');
                }

                $transaction = Transaction::create([
                    'invoice_number' => 'INV-'.now()->format('YmdHis').'-'.Str::upper(Str::random(4)),
                    'user_id' => auth()->id(),
                    'total' => $total,
                    'pay' => $data['pay'],
                    'change' => $data['pay'] - $total,
                ]);

                foreach ($lines as $line) {
                    $transaction->details()->create([
                        'product_id' => $line['product']->id,
                        'qty' => $line['qty'],
                        'price' => $line['price'],
                        'subtotal' => $line['subtotal'],
                    ]);

                    $line['product']->decrement('stock', $line['qty']);
                }

                return $transaction;
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->withErrors(['items' => $e->getMessage()]);
        }

        return redirect()->route('pos.index')->with(
            'success',
            "Transaksi {$transaction->invoice_number} berhasil. Kembalian: Rp"
                .number_format($transaction->change, 0, ',', '.')
        );
    }

    /**
     * Riwayat transaksi.
     */
    public function history()
    {
        $transactions = Transaction::with('user')
            ->withCount('details')
            ->latest()
            ->paginate(10);

        return view('pos.history', compact('transactions'));
    }
}
