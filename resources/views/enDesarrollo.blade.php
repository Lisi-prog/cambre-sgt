@extends('layouts.app')

@section('titulo', 'Inicio')

@section('content')
    <style>
        .sombra{
            box-shadow: 2px 2px 5px;
        }
    </style>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">CAMBRE SGI</h3>
        </div>
        <div class="section-body">
            <div class="row" style="height: 10vh;">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center my-auto py-3" style="background-color:aliceblue;">
                    <h2 class="">Actualmente en desarrollo.</h2>
                    <img  src="{{ asset('img/en-construccion.png') }}" width="200px" alt="">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                </div>
            </div>
        </div>
        

        <script>
            

        </script>

    </section>
    
@endsection
