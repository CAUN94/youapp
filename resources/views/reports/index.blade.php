@extends('layouts.layout')
@section('container')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reportes del Año</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Descargar Reporte</a> --}}
    </div>

    <!-- Content Row -->

    <div class="row">
    	<div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Año {{date('Y')}}</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="actualyear"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Año {{date('Y')-1}}</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="lastyear"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Atenciones {{date('Y')}}</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="conveniosActual"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Atenciones {{date('Y')-1}}</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="conveniosLast"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('scripts')
<script type="text/javascript">
	lastYear = {!! json_encode($lastyear, JSON_HEX_TAG) !!}
</script>
<script type="text/javascript">
	actualYear = {!! json_encode($actualyear, JSON_HEX_TAG) !!}
</script>
<script type="text/javascript">
    conveniosLast = {!! json_encode($conveniosLast, JSON_HEX_TAG) !!}
</script>
<script type="text/javascript">
    conveniosActual = {!! json_encode($conveniosActual, JSON_HEX_TAG) !!}
</script>

<script type="text/javascript" src="{{ asset('vendor/chart.js/Chart.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/charts/area_finance.js')}}"></script>
<script type="text/javascript" src="{{ asset('vendor/chart.js/Chart.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/charts/area_appoiments.js')}}"></script>
@stop
