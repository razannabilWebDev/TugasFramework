<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-card>
                <h3 class="text-lg font-semibold mb-2">Ringkasan Hari Ini</h3>
                <p class="text-gray-600">Selamat datang, {{ auth()->user()->name }}.</p>
            </x-card>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"">
        <h2 class="text-xl font-bold mb-4">Data Stok Barang</h2>
        
        <!-- Contoh Pengujian Secara Langsung -->
        <div class="mb-6 space-x-2 border-b pb-4">
            <span class="text-sm text-gray-500">Test satuan: </span>
            <x-badge status="Aman" />
            <x-badge status="Menipis" />
            <x-badge status="Habis" />
        </div>

        <!-- Contoh Implementasi Nyata di Tabel -->
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border-b">Nama Barang</th>
                    <th class="p-3 border-b text-center">Sisa Stok</th>
                    <th class="p-3 border-b text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-3 border-b">Laptop Asus ROG</td>
                    <td class="p-3 border-b text-center">25</td>
                    <td class="p-3 border-b text-center"><x-badge status="Aman" /></td>
                </tr>
                <tr>
                    <td class="p-3 border-b">Mouse Logitech</td>
                    <td class="p-3 border-b text-center">4</td>
                    <td class="p-3 border-b text-center"><x-badge status="Menipis" /></td>
                </tr>
                <tr>
                    <td class="p-3 border-b">Keyboard Mekanikal</td>
                    <td class="p-3 border-b text-center">0</td>
                    <td class="p-3 border-b text-center"><x-badge status="Habis" /></td>
                </tr>
            </tbody>
        </table>
    </div>
</x-app-layout>

