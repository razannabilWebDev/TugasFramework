<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Data Pengguna</h2>
            <a href="{{ route('users.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                + Tambah Pengguna
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md text-sm">{{ session('error') }}</div>
                @endif

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Nama</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Email</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Role</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                        <tr>
                            <td class="px-4 py-2 text-sm">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-sm">{{ $user->email }}</td>
                            <td class="px-4 py-2 text-sm text-center">
                                <x-badge :status="$user->role === 'admin' ? 'Admin' : 'Kasir'" />
                            </td>
                            <td class="px-4 py-2 text-sm text-center space-x-2">
                                <a href="{{ route('users.edit', $user) }}" class="text-indigo-600">Ubah</a>

                                @if ($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}?')"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
