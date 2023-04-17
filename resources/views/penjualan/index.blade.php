<x-app-layout>
    <x-slot name="header">
        <div class="submenu">
            <a class="handphone" href="route('handphone')">Handphone</a>
            <a class="aksesoris" href="#">Aksesoris</a>
            <a class="pulsa" href="#">Pulsa</a>
            <a class="servis" href="#">Servis</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @yield('main-content')
            </div>
        </div>
    </div>
</x-app-layout>