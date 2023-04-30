@extends('produk.index')
@section('main-content')
    <div class="item-menus row my-3">
        <div class="col-12 col-sm-8 col-md-6">
            <button class="add-item btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addOperator">
                <i class="fa fa-plus"></i>
                Tambah Operator
            </button>
            <button class="add-item btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addItem">
                <i class="fa fa-plus"></i>
                Tambah Nominal
            </button>
            <div class="d-inline ml-4">
                <form class="formFilter d-inline" method="post" action="{{ route('pulsa') }}">
                    @csrf
                    <label>
                        Filter Item <br>
                        <select class="filter-items" name="filter">
                            <option></option>
                            <option value="All Items">All items</option>
                            @foreach($item_list as $item)
                                <option value="{{ $item->operator }}">{{ $item->operator }}</option>
                            @endforeach
                        </select>
                    </label>
                </form>
            </div>
        </div>
    </div>
    <span>Pilih Provider</span>
    <div class="operator-list">
        <div class="row">
            {{-- @php
                dd($item_list);
            @endphp --}}
            @foreach($item_dislay as $item)
            <div class="col-6 col-sm-4 col-md-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#operator{{ $item->id }}Nominal">
                    <div class="card shadow-md" style="height: 10rem;">
                        <div class="card-header">
                            <strong>{{ $item->operator }}</strong>
                        </div>
                        <div class="card-body">
                            <img class="img-operator" src="{{ asset('') }}picture/pulsa/{{ $item->picture }}" alt="picture">
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addItem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('store-pulsa') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal pulsa</label>
                            <input type="text" name="nominal" class="form-control" id="nominal" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label>
                                Filter Item <br>
                                <select class="operator" name="operator">
                                    <option>pilih operator</option>
                                    @foreach($item_list as $item)
                                        <option value="{{ $item->id }}">{{ $item->operator }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" name="harga" class="form-control" id="harga" placeholder="Rp." autocomplete="off">
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

    <div class="modal fade" id="addOperator" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('store_saldo') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="operator" class="form-label">Nama Operator</label>
                            <input type="text" name="operator" class="form-control" id="operator" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="saldo" class="form-label">Saldo</label>
                            <input type="text" name="saldo" class="form-control" id="saldo" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="formFileSm" class="form-label">Foto Operator</label>
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

    @foreach($item_dislay as $item)
    <div class="modal fade" id="operator{{ $item->id }}Nominal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Pulsa {{ $item->operator }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach($item_nominal as $key => $nominal)
                        @if($item->operator == $nominal->operator)
                        <div class="col-6">
                            <a href="#" data-id="{{ $nominal->id }}" class="item-selected" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#selectedItem">
                                <div class="card mb-3">
                                    <div class="card-body d-flex justify-content-center flex-column">
                                        <img style="width: 8rem" src="{{ asset('') }}img/{{ strtolower($nominal->operator) }}-logo.png" alt="logo-operator">
                                        Pulsa {{ number_format($nominal->nominal) }}
                                    </div>
                                    <div class="card-footer">
                                        <small>
                                            <strong >Rp.{{ number_format($nominal->price,2,',','.') }}</strong>
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="modal fade" id="selectedItem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('checkout-pulsa') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Checkout</h5>
                        <button type="button" class="btn btn-outline-secondary close-nominal-selected" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-column child-nominal-selected">
                            <label for="nama">
                                Nama (Optional)
                                <input class="form-control" type="text" id="nama" name="nama" autocomplete="off">
                            </label> 
                            <label class="mt-3">
                                * Masukan Nomor Telepon
                                <input class="form-control" type="text" name="no_tlp" placeholder="082****" autofocus autocomplete="off">
                            </label> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex flex-column justify-content-end">
                            <button type="submit" class="btn btn-outline-secondary">Send</button>
                            <label for="save-number" class="mt-2 save-number">
                                <small>Save No.Hp</small>
                                <input class="form-control" type="checkbox" name="save_number" id="save-number">
                            </label>
                        </div>
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
                placeholder: "{{ $item_filtered == null ? 'Filter item..' : $item_filtered }}",
                allowClear: true
            });

            $('.filter-items').change(function() {
                $('.formFilter').submit();
            });

            $('.filter-items').val('{{ $item_filtered }}')

            $('.item-selected').click(function() {
                let id_items = $(this).data('id');
                let element = $(`
                        <label class="mt-3 list-price">
                            * Harga
                            @foreach($item_nominal as $nominal)
                                <input data-price="y" data-id="{{ $nominal->id }}" class="form-control" type="text" value="Rp.{{ number_format($nominal->price,2,',','.') }}" name="price" disabled>
                                <input data-price="y" data-id="{{ $nominal->id }}" class="form-control" type="text" value="{{ $nominal->price }}" name="price" hidden>
                            @endforeach
                        </label> 
                        <input value="${id_items}" name="id_items" hidden>
                        `);
                    
                element.find(`input[data-price='y'][data-id!=${id_items}]`).remove();
                $('.child-nominal-selected').append(element);
            });

            $('.close-nominal-selected').click(function() {
                $('.child-nominal-selected').find('.list-price').remove();
            });

            let checkbox = $(document).find('.save-number');
            let inputName = $(document).find('#nama');

            checkbox.hide();
            inputName.keyup(function() { 
                let value = $(this).val();
                value.length > 0 ? checkbox.show() : checkbox.hide();
            });

            checkbox.click(function() {
                console.log(checkbox.is(':checked'))
            });
        });
    </script>
@stop