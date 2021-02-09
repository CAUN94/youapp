var table = $('#occupationTable');
table.find("tbody tr").remove();
actions.forEach(function (action) {
    table.append("<tr><td>" + action['Profesional'] + "</td><td>" + action['Atenciones'] + "</td><td>" + action['Convenio'] + "</td><td>" + action['Sin_Convenio'] + "</td><td>" + action['Embajador'] + "</td><td>" + action['Prestación'] + "</td><td>" + action['Abono'] + "</td></tr>");
});

$(document).ready( function () {
    $('#occupationTable').DataTable();
} );
