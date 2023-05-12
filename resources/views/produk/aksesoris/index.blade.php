@extends('produk.index')
@section('navigation-produk')
    @include('layouts.navigation-produk')
@stop
@section('main-content')
    <link href="{{ asset('css/aksesoris.css') }}" rel="stylesheet" />
    <div class="item-menus row my-3">
        <div class="col-12 d-flex justify-between">
            <div class="">
                <button class="add-item btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addItem">
                    <i class="fa fa-plus"></i>
                    Tambah Item
                </button>
            </div>
            <div class="cart-place">
                <a href="{{ route('cart') }}">
                    <div class="cart">
                        <img class="cart" src="{{ asset('img/cart-icon.png') }}" alt="icon-cart">
                    </div>
                </a>
                @if(count($cart) > 0)
                <span class="cart-notif">
                    <b>{{ count($cart) }}</b>
                </span>
                @endif
            </div>
        </div>
    </div>

    <div class="product-list">
        <div class="row">
            @foreach($item_display as $item)
            <div class="col-6 col-sm-4 col-md-3">
                <div class="card shadow-md" style="height: 23rem;">
                    <div class="card-header">
                        <b>{{ $item->name }}</b>
                    </div>
                    <div class="card-body">
                        <div class="img-place">
                            <img class="image-items d-inline" src="{{ asset('') }}picture/aksesoris/{{ $item->picture }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="d-flex justify-between">
                        </span>
                        <hr class="my-2">
                        <div class="action">
                            <div class="sub-action d-flex">
                                <form action="" method="POST">
                                    
                                    <button type="submit" data-item="" class="btn btn-sm btn-outline-danger show_confirm mr-2">Delete</button>
                                </form>
                                <a class="btn btn-outline-success btn-sm" href="#">
                                    Edit
                                </a>
                            </div>
                            <a href="#" class="d-block btn btn-sm btn-success sell">Jual</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="addItem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('store-aksesoris') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control" id="kategori" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Item</label>
                            <input type="text" name="nama" class="form-control" id="nama" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="formFileSm" class="form-label">Foto Produk</label>
                            <input class="form-control" name="picture" id="formFileSm" type="file">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan"></textarea>
                        </div>
                        <hr class="mb-3">
                        <div class="mb-3">
                            <div class="d-flex">
                                <input type="text" name="varian[]" class="form-control" placeholder="Varian.." autocomplete="off">
                            </div> 
                            <input type="text" name="harga[]" id="item_price" class="form-control mt-2" placeholder="Harga.." autocomplete="off">
                            <input type="number" name="stok[]" class="form-control mt-2" autocomplete="off" placeholder="stok..">
                        </div>
                        <div class="varian">
                            
                        </div>
                        <div class="mb-3">
                            <a href="#" class="btn btn-secondary btn-sm btn-varian">+ Tambah Varian</a>
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
@stop
@section('script')
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-varian', function (e) { 
            let el = `
                <div class="parent-varian"><hr>
                    <span style="cursor: pointer" class="badge bg-danger delete-varian mt-2">Hapus</span>
                    <input type="text" name="varian[]" class="form-control mt-2" placeholder="Varian.." autocomplete="off">
                    <input type="text" name="harga[]" id="item_price" class="form-control mt-2" placeholder="Harga.." autocomplete="off">
                    <input type="number" name="stok[]" class="form-control my-2" autocomplete="off" placeholder="123">
                </div>`; 
            $(document).find('.varian').append(el);
        });

        $(document).on('click', '.delete-varian', function(e) {
            $(e.target).parent('.parent-varian').fadeOut(300, function() {
                $(e.target).parent('.parent-varian').remove();
            });
        });

        $('.show_confirm').click(function(event) {
            let form = $(this).closest("form");
            let name = $(this).data("name");
            let item = $(this).data("item");
            event.preventDefault();
            swal({
                title: `Lanjutkan Menghapus?`,
                text: `${item} akan di hapus dari daftar!`,
                icon: "warning",
                buttons: ['No!', true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if(willDelete) {
                    form.submit();
                }
            });
        });
    });
</script>
@stop