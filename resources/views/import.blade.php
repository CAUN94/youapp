@extends('layouts.layout')

@section('content')
@section('container')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard You</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->

    <div class="row">
    	<div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Ultima Actualización</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <ul>
                        	<li>Actions: {{$action_last}}</li>
                        	<li>Appointments: {{$appointment_last}}</li>
                        </ul>
                </div>
            </div>
        </div>

    	<div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Actions Excel</h6>
                    @if(session()->has('message-actions'))
				        <small>{{ session()->get('message-actions') }}</small>
					@endif
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Estimad@ Nombre de Paciente: -->
                    <form method="POST" action="{{url('/actions')}}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<fieldset class="form-group">
							<div class="form-group">
							    <input name="excel" type="file" class="form-control-file" id="field_path1">
							  </div>
							<small>
								Buscar ListadoAcciones.
								<a href="https://youjustbetter.softwaremedilink.com/reportesdinamicos"
									target="_blank">
									 Descargar
								</a>
							</small>
						</fieldset>

						<button type="submit" class="mt-2 btn btn-primary btn-lg btn-block">Subir</button>
					</form>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Appointments Excel</h6>
                    @if(session()->has('message-appointments'))
				        <small>{{ session()->get('message-appointments') }}</small>
					@endif
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Estimad@ Nombre de Paciente: -->
                    <form method="POST" action="{{url('/appointments')}}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<fieldset class="form-group">
							<div class="form-group">
							    <input name="excel" type="file" class="form-control-file" id="field_path2">
							  </div>
							<small>
								Buscar citas.
								<a href="https://youjustbetter.softwaremedilink.com/reportesdinamicos"
									target="_blank">
									 Descargar
								</a>
							</small>
						</fieldset>

						<button type="submit" class="mt-2 btn btn-primary btn-lg btn-block">Subir</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@endsection
