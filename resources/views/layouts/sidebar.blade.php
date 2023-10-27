<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logo-cambre.png') }}" width="100"
             alt="Infyom Logo">
        <a href="{{ url('/') }}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/') }}" class="small-sidebar-text">
            <img class="navbar-brand-full" src="{{ asset('img/logo-cambre-ol.png') }}" width="70px" alt=""/>
        </a>
    </div>
    <ul class="sidebar-menu">
        @include('layouts.menu')
    </ul>
</aside>
