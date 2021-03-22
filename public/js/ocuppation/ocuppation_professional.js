
var table = $('#occupationTable');
console.log(treatments)
table.find("tbody tr").remove();
treatments.forEach(function (treatment) {
    table.append("<tr><td>"
    + treatment['date'].slice(0, 10) + "</td><td>"
    + treatment['paciente'] + "</td><td>"
    + treatment['Convenio'] + "</td><td>"
    + treatment['Sin_Convenio'] + "</td><td>"
    + treatment['Embajador'] + "</td><td>"  + treatment['Prestación'] + "</td></tr>");
});

$(document).ready( function () {
    $('#occupationTable').DataTable();
} );
