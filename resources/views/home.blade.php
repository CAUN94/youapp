@extends('layouts.layout')

@section('content')
@section('container')
<div class="container-fluid">
    @if(auth::user()->hasrole('admin'))
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard You</h1>
    </div>

    <div class="row">
    	<div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Ultima Actualización</h6>
                    @if(session()->has('you-update'))
                        <small>{{ session()->get('you-update') }}</small>
                    @endif
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <ul>
                            @if($last_benefit < 2)
                                <li>Prestaciones Actualizada</li>
                            @else
                                <li>Prestaciones No Actualizada</li>
                            @endif
                            @if($last_category < 2)
                                <li>Categorias Actualizada</li>
                            @else
                                <li>Categorias No Actualizada</li>
                            @endif
                            @if($last_patient < 2)
                                <li>Pacientes Actualizada</li>
                            @else
                                <li>Pacientes No Actualizada</li>
                            @endif
                            @if($last_status < 2)
                                <li>Estados Actualizada</li>
                            @else
                                <li>Estados No Actualizada</li>
                            @endif
                            @if($last_sucursal < 2)
                                <li>Sucursales Actualizada</li>
                            @else
                                <li>Sucursales No Actualizada</li>
                            @endif
                            @if($last_treament < 2)
                                <li>Tratamientos Actualizada</li>
                            @else
                                <li>Tratamientos No Actualizada</li>
                            @endif
                        </ul>
                </div>
            </div>
        </div>

    	<div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Actualizar Base de Datos</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <a href="{{route('you-update-appointments')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Actualizar Base de Datos</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <a href="{{route('you-update-categories')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Actualizar Base de Datos</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <a href="{{route('you-update-treatments')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Actualizar Base de Datos</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <a href="{{route('you-update-payments')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>
        </div>


    </div>
    @else
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hola {{ auth::user()->name}}</h1>
        </div>
    @endif
</div>
@endsection
@endsection
