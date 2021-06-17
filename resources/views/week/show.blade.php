@extends('layouts.layout')
@section('container')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reportes Semanal</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Descargar Reporte</a>
    </div>

    <!-- Content Row -->
    <div class="row">
    	<div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Metodos de Pago:
                        {{$startOfWeek->format('M d')}}-
                        {{$endOfWeek->format('M d')}}
                    </h6>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="myPieChart"></canvas>
                            </div>
                        </div>
                        <div class="col-sm">
                            <?php $r = 243?>
                            @foreach($pay_methods_week as $pay_method)
                                <span class="my-2 d-block text-gray" style="color: rgb({{$r}}, 112, 89) !important">
                                    <i class="fas fa-circle "></i> {{$pay_method->Medio}} {{$pay_method->count}}
                                </span>
                            <?php $r = $r - 30 ?>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('scripts')
<script type="text/javascript">
	pay_methods_week = {!! json_encode($pay_methods_week, JSON_HEX_TAG) !!}
</script>
<script type="text/javascript" src="{{ asset('vendor/chart.js/Chart.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/week/chart-form-pie.js')}}"></script>
@stop
