@extends('produk.index')
@section('main-content')
    <div class="item-menus row my-3">
        <div class="col-6 col-sm-4 col-md-3">
            <button class="add-item btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addItem">
                <i class="fa fa-plus"></i>
                Tambah Item
            </button>
            <div class="dropdown d-inline ml-4">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-filter"></i>
                    Filter Handphone
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="product-list">
        <div class="row">
            @foreach($item_list as $item)
            <div class="col-6 col-sm-4 col-md-3">
                <div class="card shadow-md">
                    <div class="card-header">
                        {{ $item->name }}
                    </div>
                    <div class="card-body">
                        <img class="image-items" src="{{ asset('') }}picture/handphone/{{ $item->picture }}">
                    </div>
                    <div class="card-footer">
                        {{ $item->spesification }} <hr>
                        Rp.{{ $item->price }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addItem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Item</label>
                            <input type="text" name="nama" class="form-control" id="nama" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" name="harga" class="form-control" id="harga" placeholder="Rp." autocomplete="off">
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="spesifikasi" placeholder="Leave a comment here" id="spesifikasi" style="height: 100px"></textarea>
                            <label for="spesifikasi">Spesifikasi</label>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Stok Handphone</label>
                            <input type="number" name="stok" class="form-control" autocomplete="off" placeholder="123" id="stok">
                        </div>
                        <div class="mb-3">
                            <label for="formFileSm" class="form-label">Foto Handphone</label>
                            <input class="form-control form-control" name="picture" id="formFileSm" type="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal -->
@stop