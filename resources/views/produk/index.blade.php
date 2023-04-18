<x-app-layout>
    <x-slot name="header">
        <div class="submenu">
            <button type="button" class="btn btn-outline-primary btn-sm add-produk" data-bs-toggle="modal" data-bs-target="#addProduk">
                <i class="fa fa-plus"></i>
                Tambah Produk
            </button>
            <a class="handphone {{ str_contains(url()->current(), 'handphone') ? 'active' : '' }}" href="{{ route('handphone') }}">Handphone</a>
            <a class="pulsa {{ str_contains(url()->current(), 'pulsa') ? 'active' : '' }}" href="{{ route('pulsa') }}">Pulsa</a>
            <a class="aksesoris {{ str_contains(url()->current(), 'aksesoris') ? 'active' : '' }}" href="{{ route('aksesoris') }}">Aksesoris</a>
            <a class="servis {{ str_contains(url()->current(), 'servis') ? 'active' : '' }}" href="{{ route('servis') }}">Servis</a>
        </div>
    </x-slot>

    <!-- Modal -->
    <div class="modal fade" id="addProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addProdukLabel">Tambah Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label>
                Nama Produk
            </label>
            <input class="form-control" type="text" name="produk" autocomplete="off">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-primary">Submit</button>
        </div>
        </div>
    </div>
    </div>
    <!-- end modal -->

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="dark:bg-gray-800 overflow-hidden mt-3">
                @yield('main-content')
            </div>
        </div>
    </div>
</x-app-layout>