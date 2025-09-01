<style>
    .notify {
      min-width: 18rem;
      min-height: 4rem;
    }

    .notificaciones:hover {
        font-size: 10px;
        background-color: rgb(250, 233, 211);
    }

    .cardnotify {
        --bs-card-spacer-y: 3px;
        --bs-card-spacer-x: 5px;
        --bs-card-title-spacer-y: -0.5rem;
        --bs-card-border-width: 0.5px;
        --bs-card-border-color: var(--bs-border-color-translucent);
        --bs-card-border-radius: 0.375rem;
        --bs-card-box-shadow: ;
        --bs-card-inner-border-radius: calc(0.375rem - px);
        --bs-card-cap-padding-y: 0.5rem;
        --bs-card-cap-padding-x: 1rem;
        --bs-card-cap-bg: rgba(0, 0, 0, 0.03);
        --bs-card-cap-color: ;
        --bs-card-height: ;
        --bs-card-color: ;
        --bs-card-bg: rgb(230, 243, 255);
        --bs-card-img-overlay-padding: 1rem;
        --bs-card-group-margin: 0.75rem;
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        height: var(--bs-card-height);
        word-wrap: break-word;
        background-color: var(--bs-card-bg);
        background-clip: border-box;
        border: var(--bs-card-border-width) solid var(--bs-card-border-color);
        border-radius: var(--bs-card-border-radius);
    }
    .dropdown-title {
        display: block;
        width: 100%;
        padding: var(--bs-dropdown-item-padding-y) var(--bs-dropdown-item-padding-x);
        clear: both;
        font-weight: 400;
        color: var(--bs-dropdown-link-color);
        text-align: inherit;
        text-decoration: none;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }
    .texto-mensaje {
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
    }
    .notification-container {
        max-height: 300px; /* Ajusta según la altura de tres notificaciones */
        overflow-y: auto;
        scrollbar-width: thin; /* Para navegadores Firefox */
        scrollbar-color: #21628d #fff; /* Color del thumb y del track en Firefox */
    }

    .notification-container::-webkit-scrollbar {
        width: 12px; /* Ancho de la barra de desplazamiento en Chrome, Safari y Opera */
    }

    .notification-container::-webkit-scrollbar-track {
        background: #fff; /* Color del track (fondo de la barra de desplazamiento) */
    }

    .notification-container::-webkit-scrollbar-thumb {
        background-color: #4CAF50; /* Color del thumb (pestaña de la barra de desplazamiento) */
        border-radius: 20px; /* Redondear las esquinas del thumb */
        border: 3px solid #fff; /* Espacio entre el thumb y el track */
    }
    .ir-not:hover{
        color: #555758;
    }

</style>
<form class="form-inline mr-auto" action="#">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>
<ul class="navbar-nav navbar-right">

    @if(\Illuminate\Support\Facades\Auth::user())
                @php
                    $env = env('APP_ENV');
                @endphp
{{-- ada --}}
                @if ($env == 'development')
                    <h6 class="my-auto text-white fs-1 bg-danger rounded">VERSION DE PRUEBA DEL SGI</h6>
                @endif

                <li class="nav-item dropdown dropstart my-auto" style='$dropdown-min-width: 25rem;'>
                    @php
                            $alMenosUnaLeida = \Illuminate\Support\Facades\Auth::user()->getNotificaciones->contains('leido', 0);
                            $not_act = 0;

                            if ($alMenosUnaLeida) {
                                $not_act = 1;
                            }
                    @endphp
                    
                    <a href="#" id="mydrop" class="nav-link" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: #f9f9f9;" onclick="marcarComoLeido({{\Illuminate\Support\Facades\Auth::user()->id}})">
                        <i class="fas fa-bell fs-4"></i>
                        
                        @if ($not_act)
                            <span id="punto-not" class="position-absolute top-0 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                        @endif
                    </a>
                    <ul class="dropdown-menu notify">
                        <div class="row my-auto">
                            <div class="col-10 my-auto">
                                <li class="dropdown-title">Notificaciones</li> 
                            </div>
                            <div class="col-2 my-auto">
                                <a href="/notificaciones" class="" style="color: #191d21; text-decoration: none;">
                                    <i class="fas fa-expand-arrows-alt fs-6 ir-not"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="notification-container">
                            @if (count(\Illuminate\Support\Facades\Auth::user()->getNotificaciones) != 0)
                                @foreach (\Illuminate\Support\Facades\Auth::user()->getNotificaciones->sortByDesc('created_at') as $not)
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($not->created_at);
                                        $isToday = $createdAt->isToday();
                                    @endphp
                                    <li class="border-top">
                                        <a class="dropdown-item" href="{{ url($not->getCuerpo->url) }}">
                                            <div class="row">
                                                <div class="col-10 my-auto">
                                                    <h6>{{$not->getCuerpo->titulo ?? 'Titulo'}}</h6>
                                                </div>
                                                <div class="col-2 my-auto">
                                                    <p>{{ $isToday ? $createdAt->format('H:i') : $createdAt->format('d/m') ?? '00:00'}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="card-text texto-mensaje">{{$not->getCuerpo->mensaje ?? 'Una descripcion.'}}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <div class="cardnotify m-2">
                                    <div class="card-body">
                                        <p class="card-text">No hay notificaciones pendientes.</p>
                                    </div>
                                </div>
                            @endif
                        </div>  
                    </ul>
                </li>
               
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user px-0">
                <img alt="image" src="{{ asset('img/logo-circle-2.png') }}"
                     class="rounded-circle mr-1 thumbnail-rounded user-thumbnail " style="width: 45px">
                <div class="d-sm-none d-lg-inline-block">
                    {{\Illuminate\Support\Facades\Auth::user()->name}}
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    Bienvenido, {{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                @role('SUPERVISOR')
                <a class="dropdown-item has-icon edit-profile" href="#" data-id="{{ \Auth::id() }}">
                    <i class="fa fa-user"></i>Editar Perfil</a>
                @endrole
                <a class="dropdown-item has-icon" data-toggle="modal" data-target="#changePasswordModal" href="#" data-id="{{ \Auth::id() }}"><i
                            class="fa fa-lock"> </i>Cambiar Contraseña</a>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                   onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    @else
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{--                <img alt="image" src="#" class="rounded-circle mr-1">--}}
                <div class="d-sm-none d-lg-inline-block">{{ __('messages.common.hello') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ __('messages.common.login') }}
                    / {{ __('messages.common.register') }}</div>
                <a href="{{ route('login') }}" class="dropdown-item has-icon">
                    <i class="fas fa-sign-in-alt"></i> {{ __('messages.common.login') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('register') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
                </a>
            </div>
        </li>
    @endif
</ul>

<script>
    function marcarComoLeido(id) {
            $.when($.ajax({
            type: "post",
            url: '/notificacion/leido/'+id,
            data: {
                id: id,
            },
            success: function (response) {
                // console.log(response)
                if (response == 1) {
                    document.getElementById('punto-not').hidden = true;
                }
                
            },
            error: function (error) {
                console.log(error);
            }
            }));

        }
</script>