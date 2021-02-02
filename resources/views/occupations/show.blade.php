@extends('layouts.layout')
@section('container')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{$title}}</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-9 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pacientes</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="occupationTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Profesional</th>
                                    <th>Atenciones Totales</th>
                                    <th>Con Convenio</th>
                                    <th>Sin Convenio</th>
                                    <th>Embajador</th>
                                    <th>Prestación</th>
                                    <th>Abono</th>
                                </tr>
                            </thead>
                            <tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-3 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Totales</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Estimad@ Nombre de Paciente: -->
                    @foreach ($summary as $key => $value)
                        <li>{{ $key }}: {{ $value }}</li>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('scripts')
<script type="text/javascript">
    actions = {!! json_encode($actions, JSON_HEX_TAG) !!}
</script>
<script type="text/javascript" src="{{ asset('js/occupations.js')}}"></script>
@stop
