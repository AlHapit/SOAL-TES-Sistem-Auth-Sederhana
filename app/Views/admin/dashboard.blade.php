<x-dashboard-layout role="Admin" title="Selamat datang Admin" character="assets/character/admin-idle.png">
    <x-slot:intro>
        Selamat datang, {{ auth()->user()->name }}. Kelola akun kampus dari control room Polimind.
    </x-slot:intro>

    <section class="grid">
        <article class="card">
            <h2>Control status</h2>
            <strong>Online</strong>
        </article>

        <article class="card">
            <h2>Mahasiswa</h2>
            <strong>{{ $mahasiswa->count() }}</strong>
        </article>

        <article class="card">
            <h2>Dosen</h2>
            <strong>{{ $dosen->count() }}</strong>
        </article>
    </section>

    @foreach (['mahasiswa' => $mahasiswa, 'dosen' => $dosen] as $role => $users)
        <section class="manage card">
            <h2>Manajemen {{ $role }}</h2>

            <form class="new-user" method="POST" action="{{ route('admin.users.store', $role) }}">
                @csrf

                <input name="name" placeholder="Nama" required>
                <input name="email" type="email" placeholder="Email" required>
                <input name="password" type="password" placeholder="Password min. 6" required>
                <button class="button">Tambah</button>
            </form>

            <div class="table-wrap">
                <table class="data">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>

                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <details>
                                    <summary class="mini">Ubah</summary>

                                    <form class="new-user" method="POST" action="{{ route('admin.users.update', [$role, $user]) }}">
                                        @csrf
                                        @method('PATCH')

                                        <input name="name" value="{{ $user->name }}" required>
                                        <input name="email" type="email" value="{{ $user->email }}" required>
                                        <input name="password" type="password" placeholder="Password baru">
                                        <button class="mini">Simpan</button>
                                    </form>
                                </details>

                                <form method="POST" action="{{ route('admin.users.destroy', [$role, $user]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="mini danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Belum ada {{ $role }}.</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </section>
    @endforeach
</x-dashboard-layout>
