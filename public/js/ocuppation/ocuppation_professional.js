var table = $('#occupationTable');
table.find("tbody tr").remove();
actions.forEach(function (action) {
    table.append("<tr><td>" + action['Paciente'] + "</td><td>" + action['Convenio'] + "</td><td>" + action['Sin_Convenio'] + "</td><td>" + action['Embajador'] + "</td><td>"  + action['Prestación'] + "</td></tr>");
});

$(document).ready( function () {
    $('#occupationTable').DataTable();
} );
