<x-dashboard-layout role="Dosen" title="Selamat datang Dosen" character="assets/character/lecturer-idle.png">
    <x-slot:intro>
        Selamat datang, {{ auth()->user()->name }}. Ruang akademik dan perpustakaan digital Anda siap digunakan.
    </x-slot:intro>

    <section class="grid">
        <article class="card">
            <h2>Status</h2>
            <strong>Active</strong>
        </article>

        <article class="card">
            <h2>Role</h2>
            <strong>Dosen</strong>
        </article>

        <article class="card">
            <h2>Library Console</h2>
            <strong>Online</strong>
        </article>
    </section>
</x-dashboard-layout>
