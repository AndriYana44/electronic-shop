@extends('produk.index')
@section('main-content')
<link href="{{ asset('css/cart.css') }}" rel="stylesheet" />
    <table class="table table-bordered">
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
            @foreach($data as $key => $item)
            <tr>
                <td>
                    <div class="row">
                        <div class="col-6 d-flex flex-column">
                            <span>{{ $item->name }}</span>
                            <small>Varian: {{ $item->varian }}</small>
                        </div>
                        <div class="col-6">
                            <img class="img-cart" src="{{ asset('') }}picture/handphone/{{ $item->picture }}" alt="Produk">
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
            <td>Rp100.000,-</td>
            <td><button class="btn btn-outline-success btn-sm">Checkout</button></td>
            </tr>
        </tfoot>
    </table>
@stop

@section('script')
<script>
    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(1);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

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
        button.addEventListener("click", () => {
            // Ambil elemen yang akan dihapus (yaitu elemen induk dari tombol hapus)
            const row = button.parentElement.parentElement;

            // Hapus elemen dari dokumen
            row.remove();
        });
    });

    // Ambil semua tombol plus dan minus pada input jumlah produk
    const quantityButtons = document.querySelectorAll(".quantity button");

    // Loop melalui semua tombol dan tambahkan event listener
    quantityButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
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

            input.closest('td').nextElementSibling.textContent = `Rp${subtotal.toLocaleString()},-`;
        });
    });

    // removeButtons.forEach((button) => {
    //     button.addEventListener('click', (e) => {
    //         let url = `{{ route('') }}`
    //         $.ajax(url, {
    //             dataType: 'json',
    //             type: 'delete',
    //             success: {

    //             }
    //         })
    //     });
    // });
</script>
@stop