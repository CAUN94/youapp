@extends('layouts.layout')
@section('container')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contactos Youu</h1>
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
                        <table class="table table-bordered" id="pacientesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Pacientes</th>
                                    <th>RUT/DNI</th>
                                    <th>Sexo</th>
                                    <th>Mail</th>
                                    <th>Whatsapp</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
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
                    <h6 class="m-0 font-weight-bold text-primary">Escribir Mensaje</h6><small>En construcción</small>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Estimad@ Nombre de Paciente: -->
                    <div class="chart-pie pt-4 pb-2">
                        <textarea class="form-control" id="message" rows="8"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('scripts')
<script type="text/javascript">
    pacientes = {!! json_encode($pacientes->toArray(), JSON_HEX_TAG) !!}
</script>
<script type="text/javascript" src="/js/table.js"></script>
@stop
