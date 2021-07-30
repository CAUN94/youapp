@extends('layouts.layout')
@section('container')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Confirmaciones You</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
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
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Actualizar Citas</h6>
                    @if(session()->has('message-appointments'))
                        <small>{{ session()->get('message-appointments') }}</small>
                    @endif
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <a href="{{url('scraping-appointments')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script type="text/javascript">
    pacientes = {!! json_encode($pacientes, JSON_HEX_TAG) !!}
</script>
<script src="{{ asset('js/tomorrow/tomorrow.js')}}"></script>
@stop
