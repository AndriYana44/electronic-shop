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
            <div class="col-6 col-sm-4 col-md-3">
                <div class="card shadow-md" style="height: 23rem;">
                    <div class="card-header">
                        <b>Softcase</b>
                    </div>
                    <div class="card-body">
                        <div class="img-place">
                            <img class="image-items d-inline" src="#">
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
        </div>
    </div>
@stop