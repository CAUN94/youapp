var table = $('#professionalsTable');
table.find("tbody tr").remove();
actions.forEach(function (action) {
    table.append("<tr><td>" + action['Paciente'] + "</td><td>" + action['Fecha'].slice(0, 10) + "</td><td>" + action['Convenio_Nombre'] + "</td><td>" + action['Estado'] + "</td><td>" + action['Prestación'] + "</td><td>" + action['Abono'] + "</td></tr>");
});

$(document).ready( function () {
    $('#professionalsTable').DataTable();
} );
