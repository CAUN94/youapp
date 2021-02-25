var table = $('#occupationTable');
console.log(1);
table.find("tbody tr").remove();
actions.forEach(function (action) {
    table.append("<tr><td>" + action['Fecha'].substring(0,10) + "</td><td>" + action['Paciente'] + "</td><td>" + action['Convenio'] + "</td><td>" + action['Sin_Convenio'] + "</td><td>" + action['Embajador'] + "</td><td>"  + action['Prestación'] + "</td></tr>");
});

$(document).ready( function () {
    $('#occupationTable').DataTable();
} );
