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
            @foreach($item_display as $key => $item)
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
                        <span>{{ $item->keterangan }}</span><hr class="my-2">
                        <span class="d-flex justify-between">
                            <strong>
                                {{ number_format($item->varian->first()->price) }}
                                @if(($item->varian->first()->price - $item->varian->last()->price) > 0)
                                    - {{ number_format($item->varian->last()->price) }}
                                @endif
                            </strong>
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
                            <a href="#" class="d-block btn btn-sm btn-success sell" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#sellItem{{ $item->id }}">Jual</a>
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

    @foreach($item_display as $item)
    <div class="modal fade" id="sellItem{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="" id="sell{{ $item->id }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Jual Item ({{ $item->name }})</h5>
                        <input type="text" name="name" value="{{ $item->name }}" hidden>
                        <input type="text" name="kategori" value="aksesoris" hidden>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-7">
                                <img class="img-aksesoris-sell" src="{{ asset('') }}picture/aksesoris/{{ $item->picture }}" alt="images" style="height: 15rem;">
                            </div>
                            <div class="col-4">
                                <br> {{ $item->keterangan }}
                                <hr class="my-2">
                            </div>
                            <div class="col-12 mt-3 d-flex flex-column">
                                <span>pilih varian</span>
                                <div id="varian-alert-{{ $item->id }}" class="alert-varian my-2">
                                    <span class="px-3 py-2"  style="border-radius: 8px; font-size:14px; background-color: rgb(248 215 218);color: rgb(218 45 61);"><strong>Note:</strong> pilih varian terlebih dahulu!</span>
                                </div>
                            </div>
                            <div class="col-12">
                                @foreach($item->varian as $varian)
                                    <span style="cursor: pointer" data-aksesoris-id="{{ $item->id }}" data-varian-id="{{ $varian->id }}" class="badge bg-secondary varian-item mr-2">{{ $varian->varian }}</span>
                                @endforeach
                            </div>
                            <div class="col-3 mt-2">
                                <small>
                                    <label for="jml">
                                        Jumlah: 
                                        <div class="input-group d-flex justify-center quantity">
                                            <button type="button" class="cart-button-jml button-minus" data-field="jml" data-id="{{ $item->id }}">-</button>
                                            <input type="number" name="jml" data-id="{{ $item->id }}" class="form-control jml quantity-field" value="1" placeholder="0" id="jml{{ $item->id }}">
                                            <button type="button"class="cart-button-jml button-plus" data-field="jml" data-id="{{ $item->id }}">+</button>
                                        </div>
                                    </label>
                                </small>
                            </div>
                            <div class="col-4 mt-2">
                                <small>
                                    <label for="jml">
                                        Total Harga: 
                                        <input type="text" style="font-size: 12px" data-price="{{ $item->price }}" value="Rp.{{ number_format($item->price) }}" class="form-control" id="displaytotal{{ $item->id }}" disabled>
                                        <input type="text" value="" name="total" class="form-control" id="inputtotal{{ $item->id }}" hidden>
                                    </label>
                                </small>
                            </div>
                            <div class="col-2 mt-2 stok-{{ $item->id }} d-flex justify-content-center align-items-center"></div>
                            <input type="text" name="id_aksesoris" hidden>
                            <input type="text" name="id_varian" hidden> 
                            <input type="text" name="harga" hidden>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" data-id="{{ $item->id }}" id="btn-bayar" class="btn btn-outline-primary btn-sm">
                            Checkout
                        </button>
                        <button type="submit" data-id="{{ $item->id }}" id="btn-cart" class="btn btn-outline-secondary btn-sm">
                            Masukan Cart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@stop
@section('script')
<script>
    $(document).ready(function() {
        function incrementValue(e) {
            e.preventDefault();
            let id = $(e.target).data('id');
            let fieldName = $(e.target).data('field');
            let parent = $(e.target).closest('div');
            let currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
            let price = $(`#displaytotal${id}`).attr('data-price');

            if (!isNaN(currentVal)) {
                parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
                let fix_price = price*parent.find('input[name=' + fieldName + ']').val();
                $(`#displaytotal${id}`).val('Rp.' + number_format(fix_price));
                $(`#inputtotal${id}`).val(fix_price);
            } else {
                parent.find('input[name=' + fieldName + ']').val(1);
            }
        }

        function decrementValue(e) {
            e.preventDefault();
            let id = $(e.target).data('id');
            let fieldName = $(e.target).data('field');
            let parent = $(e.target).closest('div');
            let currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
            let price = $(`#displaytotal${id}`).attr('data-price');

            if (!isNaN(currentVal) && currentVal > 1) {
                parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
                let fix_price = price*parent.find('input[name=' + fieldName + ']').val();
                $(`#displaytotal${id}`).val('Rp.' + number_format(fix_price));
                $(`#inputtotal${id}`).val(fix_price);
            } else {
                parent.find('input[name=' + fieldName + ']').val(1);
            }
        }
        
        $.each($(`.alert-varian`), (i,v) => {
            $(v).hide();
        });

        $(document).on('click', 'button', (e) => {
            let _target = e.target.id;
            let id = $(e.target).data('id');
            if(_target.indexOf('btn-bayar') > -1) {
                e.preventDefault();
                let url = '{{ route("checkout-handphone", ":id") }}';
                url = url.replace(':id', id);
                let varianEl = $(e.target).closest('.modal-content').find('.varian-item');
                let varianSelected = 0;
                $.each(varianEl, function(i,v) {
                    varianSelected += $(v).hasClass('selected') ? 1 : 0
                });
                if(varianSelected) {
                    $(`#sell${id}`).attr('action', url).submit();
                }else{
                    $(`#varian-alert-${id}`).fadeTo(2500, 500)
                    .slideUp(500, function() {
                        $(`#varian-alert-${id}`).slideUp(500);
                    });
                }
            } else if (_target.indexOf('btn-cart') > -1) {
                e.preventDefault();
                $(`#sell${id}`).attr('action', '{{ route("cartInsert") }}').submit();
            }
        });

        let dataVarian = [];
        $(document).on('click', '.sell', function(e) {
            dataVarian = [];
            let id = $(e.target).data('id');
            $.ajax(`{{ url('') }}/produk/json/detail-aksesoris/${id}`, {
                dataType: 'json',
                type: 'get',
                success: function(res) {
                    $.each(res, (i, v) => {
                        dataVarian.push(v)
                    });
                }
            });
            console.log(dataVarian);
        });

        $('.input-group').on('click', '.button-plus', function(e) {
            let id = $(e.target).data('id');
            let x = 0;
            $('.varian-item').each((i,v) => { x += $(v).hasClass('selected') ? 1 : 0 });
            x ? incrementValue(e) : $(`#varian-alert-${id}`).fadeTo(2500, 500)
                .slideUp(500, function() {
                    $(`#varian-alert-${id}`).slideUp(500);
                });
        });

        $('.input-group').on('click', '.button-minus', function(e) {
            let id = $(e.target).data('id');
            let x = 0;
            $('.varian-item').each((i,v) => { x += $(v).hasClass('selected') ? 1 : 0 });
            x ? decrementValue(e) : $(`#varian-alert-${id}`).fadeTo(2500, 500)
                .slideUp(500, function() {
                    $(`#varian-alert-${id}`).slideUp(500);
                });
        });

        $(document).on('click', '.varian-item', function(e) {
            $('.varian-item').removeClass('bg-warning');
            $('.varian-item').removeClass('selected');
            $('.varian-item').addClass('bg-secondary');
            $(e.target).addClass('selected');
            $(e.target).addClass('bg-warning');
            $(e.target).removeClass('bg-secondary');

            let varianId = $(e.target).data('varian-id');
            let aksesorisId = $(e.target).data('aksesoris-id');
            let jml = $(`#jml${aksesorisId}`).val();

            $('input[name=id_aksesoris]').val(aksesorisId);
            $('input[name=id_varian]').val(varianId);

            $.each(dataVarian[0].varian, (i, v) => {
                if(v.id == varianId) {
                    let price = v.price*jml;
                    $('input[name=harga]').val(v.price)
                    $(`#displaytotal${aksesorisId}`).val('Rp.' + number_format(price));
                    $(`#displaytotal${aksesorisId}`).attr('data-price', v.price);
                    $(`#inputtotal${aksesorisId}`).val(price);
                    $(`.stok-${aksesorisId}`).html(`<small>stok: ${v.available_items}</small>`);
                }
            });
        });

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