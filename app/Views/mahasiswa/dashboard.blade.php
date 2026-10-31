<x-dashboard-layout role="Mahasiswa" title="Selamat datang Mahasiswa" character="assets/character/student-idle.png">
    <x-slot:intro>
        Selamat datang, {{ auth()->user()->name }}. Kamu berada di kampus pixel Polimind.
    </x-slot:intro>

    <section class="grid">
        <article class="card">
            <h2>Status</h2>
            <strong>Mahasiswa Aktif</strong>
        </article>

        <article class="card">
            <h2>Role</h2>
            <strong>Mahasiswa</strong>
        </article>

        <article class="card">
            <h2>Academic Portal</h2>
            <strong>Ready</strong>
        </article>
    </section>
</x-dashboard-layout>
