@extends('produk.index')
@section('main-content')
<link href="{{ asset('css/cart.css') }}" rel="stylesheet" />
    <span class="mb-3">
        <strong>
            <a href="{{ route('handphone') }}">
                <i class="fa fa-location-arrow"></i> Produk / 
            </a>
        </strong>Keranjang
    </span>
    @if(count($data) > 0)
        <form method="post" action="{{ route('cartCheckout') }}">
            @csrf
            <table class="table table-bordered mt-3">
                <thead class="bg-warning">
                    <tr>
                        <th class="text-center">Produk</th>
                        <th>Harga</th>
                        <th class="text-center">Jumlah</th>
                        <th>Subtotal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @foreach($data as $key => $item)
                    @php 
                        $total += $item->total;
                        $picture = $item->kategori_item == 'handphone' ? $item->picture : $item->aksesoris_picture;
                        $varian = $item->kategori_item == 'handphone' ? $item->varian : $item->varian_aksesoris;
                    @endphp
                    {{-- {{ dd($item) }} --}}
                    <tr>
                        <td class="data-cart" hidden>
                            <input class="data-id" type="number" name="id[]" value="{{ $item->id }}" hidden>
                            <input type="number" name="produk_id[]" value="{{ $item->kategori_item == 'handphone' ? $item->handphone_id : $item->aksesoris_id }}" hidden>
                            <input type="number" name="varian_id[]" value="{{ $item->kategori_item == 'handphone' ? $item->handphone_varian_id : $item->aksesoris_varian_id }}" hidden>
                            <input type="text" name="kategori[]" value="{{ $item->kategori_item }}" hidden>
                            <input type="text" name="jml[]" value="{{ $item->jumlah }}" hidden>
                            <input type="text" name="price[]" value="{{ $item->price }}" hidden>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-6 d-flex flex-column">
                                    <span>{{ $item->name }}</span>
                                    <small>Varian: {{ $varian }}</small>
                                </div>
                                <div class="col-6">
                                    <img class="img-cart" src="{{ asset('') }}picture/{{ strtolower($item->kategori_item) }}/{{ $picture }}" alt="Produk">
                                </div>
                            </div>
                        </td>
                        <td class="price">Rp.{{ number_format($item->price) }}</td>
                        <td class="text-center">
                            <div class="input-group d-flex justify-center quantity">
                                <button type="button" class="cart-button-jml button-minus" data-field="quantity">-</button>
                                <input type="number" step="1" min="1" max="" value="{{ $item->jumlah }}" name="quantity" class="quantity-field" disabled>
                                <button type="button"class="cart-button-jml button-plus" data-field="quantity">+</button>
                            </div>
                        </td>
                        <td class="sub-total">Rp.{{ number_format($item->total) }}</td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm remove">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total</td>
                        <td class="total">Rp.{{ number_format($total) }}</td>
                        <td>
                            <button type="submit" class="btn btn-outline-success btn-sm checkout-cart">
                            Checkout
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    @else
    <div class="card mt-3 shadow">
        <div class="card-body">
            <p class="card-text" style="color: rgb(218 45 61);">Keranjang kosong!</p>
            <a href="#" class="btn btn-primary mt-2">Lihat Produk</a>
        </div>
    </div>
    @endif
@stop

@section('script')
<script>
    @if($message = Session::get('success'))
        swal("{{ $message }}", {
            icon: "success",
        });
    @endif

    function incrementValue(e) {
        e.preventDefault();
        let fieldName = $(e.target).data('field');
        let parent = $(e.target).closest('div');
        let currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(1);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        let fieldName = $(e.target).data('field');
        let parent = $(e.target).closest('div');
        let currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 1) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(1);
        }
    }

    $('.input-group').on('click', '.button-plus', function(e) {
        incrementValue(e);
    });

    $('.input-group').on('click', '.button-minus', function(e) {
        decrementValue(e);
    });
    // Ambil elemen input jumlah produk
    const quantityInputs = document.querySelectorAll(".quantity-field");

    // Ambil semua tombol hapus
    const removeButtons = document.querySelectorAll(".remove");

    // Loop melalui semua tombol hapus dan tambahkan event listener
    removeButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            // Ambil elemen yang akan dihapus (yaitu elemen induk dari tombol hapus)
            e.preventDefault();
            const row = button.parentElement.parentElement;
            let idx = row.querySelector('.data-id').value;
            let url = `{{ url('') }}/cart/deleteDataCart/${idx}`;
            swal({
                text: `akan di hapus dari cart!`,
                icon: "warning",
                buttons: ['No!', true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if(willDelete) {
                    $.ajax(url, {
                        dataType: 'json',
                        type: 'delete',
                        success: function(res) {
                            let total = 0;
                            res.forEach((v) => {
                                total += (parseInt(v.price) * parseInt(v.jumlah));
                            });
                            const totalEl = document.querySelector('.total');
                            totalEl.textContent =  `Rp.${number_format(total)}`;
                            swal("Berhasil di hapus!", { icon: "success"});
                            // Hapus elemen dari dokumen
                            row.remove();
                        }
                    })
                }
            });
        });
    });

    // Ambil semua tombol plus dan minus pada input jumlah produk
    const quantityButtons = document.querySelectorAll(".quantity button");

    // Loop melalui semua tombol dan tambahkan event listener
    quantityButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            // Ambil parent element dari button
            const parentEl = button.parentElement.parentElement.parentElement;
            const idx = parentEl.querySelector('.data-id').value; 
            // Ambil input dan nilai jumlah produk
            const input = button.parentElement.querySelector("input");
            let jml = $(e.target).siblings('.quantity-field').val();
            const quantity = parseInt(input.value);

            // Batasi jumlah produk pada rentang 1-10
            if (button.classList.contains("button-plus")) {
                if (quantity < 10) {
                    jml = quantity + 1;
                }
            } else if (button.classList.contains("button-minus")) {
                if (quantity > 1) {
                    jml = quantity - 1;
                }
            }

            // Hitung ulang subtotal produk
            let price = input.closest('td').previousElementSibling.textContent.slice(2);
            price = price.match(/\d+/g).join('');
            const subtotal = parseInt(price) * parseInt(jml);

            // disabled button checkout
            const btncheckout = parentEl.parentElement.parentElement.querySelector('.checkout-cart');
            btncheckout.setAttribute('disabled', 'true');
            
            const url = `{{ url('') }}/cart/changeDataCart/${idx}`;
            $.ajax(url, {
                dataType: 'json',
                type: 'patch',
                data: {jml:jml},
                success: function(res) {
                    let total = 0;
                    res.forEach((v) => {
                        total += (parseInt(v.price) * parseInt(v.jumlah));
                    })
                    const tableEl = parentEl.parentElement.parentElement;
                    const totalEl = tableEl.querySelector('.total');
                    totalEl.textContent =  `Rp.${number_format(total)}`;
                } ,
                complete: function() {
                    btncheckout.removeAttribute('disabled');
                }
            });


            input.closest('td').nextElementSibling.textContent = `Rp${subtotal.toLocaleString()}`;
        });
    });
</script>
@stop