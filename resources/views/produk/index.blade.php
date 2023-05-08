<x-app-layout>
    <x-slot name="header">
        @yield('navigation-produk')
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="dark:bg-gray-800">
                @yield('main-content')
            </div>
        </div>
    </div>
</x-app-layout>