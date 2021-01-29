<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../../../favicon.ico">

		<title>YouApp PowerBI</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
		<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

		<!-- Custom styles for this template -->
		<link rel="stylesheet" type="text/css" href="/css/style.css">
	</head>

	<body>
		<div class="container bg-primary">
			<div class="p-3">
				@if(session()->has('message'))
				    <div class="alert alert-success">
				        {{ session()->get('message') }}
				    </div>
				@endif
				<h2>YouApp Power BI</h2>
				<form method="POST" action="{{url('/actions')}}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<fieldset class="form-group">
						<div class="form-group">
						    <label for="field_path">Subir Archivo Historial de Acciones</label>
						    <input name="excel" type="file" class="form-control-file" id="field_path">
						  </div>
						<small class="text-white">Debe ser el archivo descagargado sin modificaciones.</small>
					</fieldset>

					<button type="submit" class="btn btn-light">Subir</button>
				</form>
			</div>
		</div>

	</body>
	<script>
	$(document).ready(function(){
	    $('#myTable').dataTable();
	});
	</script>
</html>
