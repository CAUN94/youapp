var table = $('#occupationTable');
table.find("tbody tr").remove();
treatments.forEach(function (treatment) {
    table.append("<tr><td>" + treatment['professional'] + "</td><td>" + treatment['Atenciones'] + "</td><td>" + treatment['Convenio'] + "</td><td>" + treatment['Sin_Convenio'] + "</td><td>" + treatment['Embajador'] + "</td><td>" + treatment['Prestación'] + "</td><td>" + treatment['Abono'] + "</td></tr>");
});

$(document).ready( function () {
    $('#occupationTable').DataTable();
} );
