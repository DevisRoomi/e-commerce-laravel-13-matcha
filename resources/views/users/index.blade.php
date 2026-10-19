<x-app-layout>
    <div class="container py-5 my-5 text-center">
        <h2>🌿 User Dashboard</h2>
        <p class="fs-5 text-secondary">Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
    </div>
</x-app-layout>
