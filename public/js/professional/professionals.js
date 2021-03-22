var table = $('#professionalsTable');
table.find("tbody tr").remove();
console.log(professionalsOcuppation)
professionalsOcuppation.forEach(function (professionalOcuppation) {
    table.append("<tr><td>" + professionalOcuppation['patient'].name + " " + professionalOcuppation['patient'].lastnames + "</td><td>"
    	+ professionalOcuppation['date'].slice(0, 10) + "</td><td>"
    	+ professionalOcuppation['patient'].prevision + "</td><td>"
    	+ professionalOcuppation['status'].name + "</td><td>"
    	+ professionalOcuppation['benefit'] + "</td><td>"
    	+ professionalOcuppation['payment'] + "</td></tr>");
});

$(document).ready( function () {
    $('#professionalsTable').DataTable();
} );
