<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Daftar Kategori</h2>
            <a href="{{ route('categories.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 border border-green-200 px-4 py-2 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <x-card>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 border-b">#</th>
                            <th class="p-3 border-b">Nama Kategori</th>
                            <th class="p-3 border-b">Deskripsi</th>
                            <th class="p-3 border-b text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="p-3 border-b">{{ $loop->iteration }}</td>
                                <td class="p-3 border-b">{{ $category->name }}</td>
                                <td class="p-3 border-b">{{ $category->description ?? '-' }}</td>
                                <td class="p-3 border-b text-center whitespace-nowrap">
                                    <a href="{{ route('categories.edit', $category) }}"
                                        class="text-indigo-600 hover:underline">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">Belum ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
