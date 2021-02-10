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
                            <li>Treatment: {{$treatment_last}}</li>
                            <li>Payment: {{$payment_last}}</li>
                            <li>Fintoc: {{$fintoc_last}}</li>
                        </ul>
                </div>
            </div>
        </div>

    	<div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                    @if(session()->has('message-actions'))
				        <small>{{ session()->get('message-actions') }}</small>
					@endif
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <a href="{{url('scraping-actions')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>

            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Treatments</h6>
                    @if(session()->has('message-treatments'))
                        <small>{{ session()->get('message-treatments') }}</small>
                    @endif
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <a href="{{url('scraping-treatments')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>

            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Fintoc</h6>
                    @if(session()->has('message-transfers'))
                        <small>{{ session()->get('message-transfers') }}</small>
                    @endif
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <a href="{{url('transfers')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Appointments</h6>
                    @if(session()->has('message-appointments'))
				        <small>{{ session()->get('message-appointments') }}</small>
					@endif
                </div>
                <!-- Card Body -->
                <div class="card-body">
						<a href="{{url('scraping-appointments')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Payments</h6>
                    @if(session()->has('message-payments'))
                        <small>{{ session()->get('message-payments') }}</small>
                    @endif
                </div>
                <!-- Card Body -->
                <div class="card-body">
                        <a href="{{url('scraping-payments')}}" class="mt-2 btn btn-primary btn-lg btn-block">Actualizar</a >
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@endsection
