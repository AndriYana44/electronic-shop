@extends('produk.index')
@section('main-content')
    <div class="item-menus row my-3">
        <div class="col-12 d-flex justify-between">
            <div class="">
                <button class="add-item btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addItem">
                    <i class="fa fa-plus"></i>
                    Tambah Item
                </button>
                <div class="d-inline ml-4">
                    <form class="formFilter d-inline" method="post" action="{{ route('handphone') }}">
                        @csrf
                        <label>
                            Filter Item <br>
                            <select class="filter-items" name="itemFiltered">
                                <option></option>
                                <option value="All items">All items</option>
                                @foreach($item_list as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </form>
                </div>
            </div>
            <div class="cart-place">
                <div class="cart">
                    <img src="{{ asset('img/cart-icon.png') }}" alt="icon-cart">
                </div>
                @if(count($cart) > 0)
                <span class="cart-notif">
                    <b>{{ count($cart) }}</b>
                </span>
                @endif
                <div class="item-cart">
                    <div class="item">
                        <div class="col-12">
                            <div class="card">
                            @php $total = 0; @endphp
                            @foreach($cart as $c)
                            @php $total += ($c->price*$c->jumlah); @endphp
                            <div class="card-body d-flex flex-column">
                                <div class="card-title">
                                    <span class="badge bg-danger">x</span>
                                    <strong>{{ $c->name }}</strong>
                                </div>
                                <small class="card-text">Varian: {{ $c->itemHandphone->first()->varian }}</small>
                                <span class="d-flex flex-column">
                                    <b><small class="text-success">Rp.{{ number_format($c->price) }}</small></b> 
                                    <div class="input-group">
                                        <input type="button" value="-" class="button-minus" data-field="quantity">
                                        <input type="number" step="1" max="" value="1" name="quantity" class="quantity-field">
                                        <input type="button" value="+" class="button-plus" data-field="quantity">
                                    </div>
                                </span>
                            </div>
                            <hr>
                            @endforeach
                            <div class="card-footer d-flex flex-column">
                                <span>
                                    <strong>
                                        <b class="text-success">Total Harga: Rp.{{ number_format($total) }}</b>
                                    </strong>
                                </span>
                                <a href="#" class="btn btn-primary btn-sm">Checkout</a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <img class="image-items d-inline" src="{{ asset('') }}picture/handphone/{{ $item->picture }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <span>{{ $item->spesification }}</span><hr class="my-2">
                        <span class="d-flex justify-between">
                            @if(count($item->varian) > 1)
                            <strong>{{ number_format($item->varian->first()->price) }} - {{ number_format($item->varian->last()->price) }}</strong>
                            @else
                            <strong>{{ number_format($item->varian->first()->price) }}</strong>
                            @endif
                            <small>Stok: {{ $item->available_items }}</small>
                        </span>
                        <hr class="my-2">
                        <div class="action">
                            <div class="sub-action d-flex">
                                <form action="{{ route('delete-handphone', $item->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" data-item="{{ $item->name }}" class="btn btn-sm btn-outline-danger show_confirm mr-2" data-toggle="tooltip" title='Delete'>Delete</button>
                                </form>
                                <a class="btn btn-outline-success btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#editItem{{ $item->id }}">
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

    <!-- Modal -->
    <div class="modal fade" id="addItem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('store-handphone') }}" enctype="multipart/form-data">
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
                            <input class="form-control" name="picture" id="formFileSm" type="file">
                        </div>
                        <hr class="mb-3">
                        <div class="mb-3">
                            <div class="d-flex">
                                <input type="text" name="varian[]" class="form-control" placeholder="Varian.." autocomplete="off">
                            </div> 
                            <input type="text" name="harga[]" id="item_price" class="form-control mt-2" placeholder="Harga.." autocomplete="off">
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
                        <input type="text" name="kategori" value="handphone" hidden>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-7">
                                <img class="img-handphone-sell" src="{{ asset('') }}picture/handphone/{{ $item->picture }}" alt="images" style="height: 15rem;">
                            </div>
                            <div class="col-4">
                                Spek: <br> {{ $item->spesification }}
                                <hr class="my-2">
                                <small>Tersedia: {{ $item->available_items }}</small>
                            </div>
                            <div class="col-12 mt-3">
                                <span>pilih varian</span>
                            </div>
                            <div class="col-12">
                                @foreach($item->varian as $varian)
                                    <span style="cursor: pointer" data-handphone-id="{{ $item->id }}" data-varian-id="{{ $varian->id }}" class="badge bg-secondary varian-item mr-2">{{ $varian->varian }}</span>
                                @endforeach
                            </div>
                            <div class="col-2 mt-2">
                                <small>
                                    <label for="jml">
                                        Jumlah: 
                                        <input type="number" name="jml" data-id="{{ $item->id }}" class="form-control jml" value="1" placeholder="0" id="jml{{ $item->id }}">
                                    </label>
                                </small>
                            </div>
                            <div class="col-6 mt-2">
                                <small>
                                    <label for="jml">
                                        Total Harga: 
                                        <input type="text" style="font-size: 12px" data-price="{{ $item->price }}" value="Rp.{{ number_format($item->price) }}" class="form-control" id="displaytotal{{ $item->id }}" disabled>
                                        <input type="text" value="" name="total" class="form-control" id="inputtotal{{ $item->id }}" hidden>
                                    </label>
                                </small>
                            </div>
                            <input type="text" name="id_handphone" hidden>
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

    @foreach($item_display as $item)
    <div class="modal fade" id="editItem{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('update-handphone', $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Item ({{ $item->name }})</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Item</label>
                            <input type="text" name="nama" value="{{ $item->name }}" class="form-control" id="nama" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" name="harga" value="{{ number_format($item->price) }}" class="form-control" id="harga" placeholder="Rp." autocomplete="off">
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="spesifikasi" placeholder="Leave a comment here" id="spesifikasi" style="height: 100px">{{ $item->spesification }}</textarea>
                            <label for="spesifikasi">Spesifikasi</label>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Stok Handphone</label>
                            <input type="number" name="stok" value="{{ $item->available_items }}" class="form-control" autocomplete="off" placeholder="123" id="stok">
                        </div>
                        <div class="mb-3">
                            <label for="formFileSm" class="form-label">Foto Handphone</label>
                            <input class="form-control form-control" value="{{ $item->picture }}" name="picture" id="formFileSm" type="file">
                        </div>
                        <div class="mb-3">
                            <a href="#" >Tambah pilihan item</a>
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
    @endforeach
    <!-- end modal -->
@stop
@section('script')
    <script>

        $(document).ready(function() {
            $('.cart-notif').fadeIn('3000');

            $('.filter-items').select2({
                placeholder: "{{ $item_filtered == null ? 'Filter item..' : $item_filtered}}",
                allowClear: true
            });

            $('.filter-items').change(function() {
                $('.formFilter').submit();
            });

            $('.filter-items').val('{{ $item_filtered }}')

            $(document).on('keyup', '#item_price', function() {
                let currentVal = $(this).val();
                $(this).val(number_format(currentVal));
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

            @if($message = Session::get('success'))
                swal("{{ $message }}", {
                    icon: "success",
                });
            @endif

            $(document).on('click', 'button', (e) => {
                _target = e.target.id;
                id = $(e.target).data('id');
                if(_target.indexOf('btn-bayar') > -1) {
                    e.preventDefault();
                    let url = '{{ route("checkout-handphone", ":id") }}';
                    url = url.replace(':id', id);
                    $(`#sell${id}`).attr('action', url).submit();
                } else if (_target.indexOf('btn-cart') > -1) {
                    e.preventDefault();
                    let url = '{{ route("cart", ":id") }}';
                    url = url.replace(':id', id);
                    $(`#sell${id}`).attr('action', '{{ route("cart") }}').submit();
                }
            });

            $(document).on('click', '.btn-varian', function (e) { 
                let el = `
                    <div class="parent-varian"><hr>
                        <span style="cursor: pointer" class="badge bg-danger delete-varian mt-2">Hapus</span>
                        <input type="text" name="varian[]" class="form-control mt-2" placeholder="Varian.." autocomplete="off">
                        <input type="text" name="harga[]" id="item_price" class="form-control my-2" placeholder="Harga.." autocomplete="off">
                    </div>`; 
                $(document).find('.varian').append(el);
            });

            $(document).on('click', '.delete-varian', function(e) {
                $(e.target).parent('.parent-varian').fadeOut(300, function() {
                    $(e.target).parent('.parent-varian').remove();
                });
            });

            let dataVarian = [];
            $(document).on('click', '.sell', function(e) {
                let id = $(e.target).data('id');
                $.ajax(`{{ url('') }}/produk/json/detail-handphone/${id}`, {
                    dataType: 'json',
                    type: 'get',
                    success: function(res) {
                        $.each(res, (i, v) => {
                            dataVarian.push(v)
                        });
                    }
                });
            });

            $(document).on('click', '.varian-item', function(e) {
                $('.varian-item').removeClass('bg-warning');
                $('.varian-item').addClass('bg-secondary');
                $(e.target).addClass('bg-warning');
                $(e.target).removeClass('bg-secondary');

                let varianId = $(e.target).data('varian-id');
                let handphoneId = $(e.target).data('handphone-id');
                let jml = $(`#jml${handphoneId}`).val();

                $('input[name=id_handphone]').val(handphoneId);
                $('input[name=id_varian]').val(varianId);

                $.each(dataVarian[0].varian, (i, v) => {
                    if(v.id == varianId) {
                        let price = v.price*jml;
                        $('input[name=harga]').val(v.price)
                        $(`#displaytotal${handphoneId}`).val('Rp.' + number_format(price));
                        $(`#displaytotal${handphoneId}`).attr('data-price', v.price);
                        $(`#inputtotal${handphoneId}`).val(price);
                    }
                });
            });

            $(document).on('change', '.jml', function(e) {
                let jml = $(this).val();
                let id = $(this).data('id');
                let price = $(`#displaytotal${id}`).attr('data-price');

                if(jml < 1) {
                    $(this).val(1);
                    jml = 1;
                }
                
                fix_price = price*jml;

                $(`#displaytotal${id}`).val('Rp.' + number_format(fix_price));
                $(`#inputtotal${id}`).val(fix_price);
            });

            $('.cart').click(function(e) {
                $('.item-cart').toggleClass('item-cart-show');
                let w = $(document).find('.item-cart').width();
                let h = $('.item-cart').height();
                if($('.item-cart').hasClass('item-cart-show')) {
                    $('.item-cart').css('bottom', `-${h+10}px`);
                    $('.item-cart').css('left', `-${w}px`);
                }else{
                    $('.item-cart').removeAttr('style');
                }
            });

            function incrementValue(e) {
                e.preventDefault();
                var fieldName = $(e.target).data('field');
                var parent = $(e.target).closest('div');
                var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                if (!isNaN(currentVal)) {
                    parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
                } else {
                    parent.find('input[name=' + fieldName + ']').val(0);
                }
                }

                function decrementValue(e) {
                e.preventDefault();
                var fieldName = $(e.target).data('field');
                var parent = $(e.target).closest('div');
                var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                if (!isNaN(currentVal) && currentVal > 0) {
                    parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
                } else {
                    parent.find('input[name=' + fieldName + ']').val(0);
                }
                }

                $('.input-group').on('click', '.button-plus', function(e) {
                incrementValue(e);
                });

                $('.input-group').on('click', '.button-minus', function(e) {
                decrementValue(e);
                });
        });
    </script>
@stop