<div class="submenu">
    <a class="handphone {{ str_contains(url()->current(), 'handphone') ? 'active' : '' }}" href="{{ route('handphone') }}">
        <i class="fa fa-mobile mr-2"></i>
        Handphone
    </a>
    <a class="aksesoris {{ str_contains(url()->current(), 'aksesoris') ? 'active' : '' }}" href="{{ route('aksesoris') }}">
        <i class="fa fa-gift  mr-2"></i>
        Aksesoris
    </a>
    <a class="pulsa {{ str_contains(url()->current(), 'pulsa') ? 'active' : '' }}" href="{{ route('pulsa') }}">
        <i class="fa fa-credit-card  mr-2"></i>
        Pulsa
    </a>
    <a class="servis {{ str_contains(url()->current(), 'servis') ? 'active' : '' }}" href="{{ route('servis') }}">
        <i class="fa fa-cogs mr-2"></i>
        Servis
    </a>
</div>