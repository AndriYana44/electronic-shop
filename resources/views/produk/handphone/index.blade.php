@extends('produk.index')
@section('main-content')
    <div class="item-menus row my-3">
        <div class="col-12 col-sm-8 col-md-6">
            <button class="add-item btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addItem">
                <i class="fa fa-plus"></i>
                Tambah Item
            </button>
            <div class="d-inline ml-4">
                <form class="formFilter d-inline" method="post" action="{{ route('handphone') }}">
                    @csrf
                    <select class="filter-items d-inline" name="itemFiltered">
                        <option></option>
                        <option value="All items">All items</option>
                        @foreach($item_list as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="product-list">
        <div class="row">
            @foreach($item_display as $item)
            <div class="col-6 col-sm-4 col-md-3">
                <div class="card shadow-md">
                    <div class="card-header">
                        {{ $item->name }}
                    </div>
                    <div class="card-body">
                        <img class="image-items d-inline" src="{{ asset('') }}picture/handphone/{{ $item->picture }}">
                    </div>
                    <div class="card-footer">
                        <span>{{ $item->spesification }}</span><hr class="my-2">
                        <span>
                            <strong>Rp.{{ number_format($item->price,2,',','.') }}</strong>
                        </span>
                        <hr class="my-2">
                        <div class="action">
                            <div class="sub-action">
                                <a class="mr-3 text-danger" href="#">
                                    Hapus
                                </a>
                                <a class="ml-3 text-success" href="#">
                                    Edit
                                </a>
                            </div>
                            <span>Stok: {{ $item->available_items }}</span>
                        </div>
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
@section('script')
    <script>
        $(document).ready(function() {
            $('.filter-items').select2({
                placeholder: "{{ $item_filtered == null ? 'Filter item..' : $item_filtered}}",
                allowClear: true
            });

            $('.filter-items').change(function() {
                $('.formFilter').submit();
            });

            $('.filter-items').val('{{ $item_filtered }}')
        });
    </script>
@stop