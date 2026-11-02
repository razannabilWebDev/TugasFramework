<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Laporan penjualan per produk dan ringkasan omzet.
     */
    public function sales()
    {
        $summary = [
            'transactions' => DB::table('transactions')->count(),
            'revenue' => (int) DB::table('transactions')->sum('total'),
            'items_sold' => (int) DB::table('transaction_details')->sum('qty'),
        ];

        $products = Product::query()
            ->leftJoin('transaction_details', 'transaction_details.product_id', '=', 'products.id')
            ->selectRaw('products.id, products.code, products.name, products.unit')
            ->selectRaw('COALESCE(SUM(transaction_details.qty), 0) as qty_sold')
            ->selectRaw('COALESCE(SUM(transaction_details.subtotal), 0) as revenue')
            ->groupBy('products.id', 'products.code', 'products.name', 'products.unit')
            ->orderByDesc('qty_sold')
            ->paginate(10);

        return view('report.sales', compact('summary', 'products'));
    }
}
