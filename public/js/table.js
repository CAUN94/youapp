var table = $('#pacientesTable');
console.log(pacientes)
table.find("tbody tr").remove();
pacientes.forEach(function (paciente) {
    table.append("<tr><td>" + nombre + "</td><td>" + paciente['Rut_Paciente'] + "</td><td>" + mail + "</td><td>" + link + "</td></tr>");
});

$(document).ready( function () {
    $('#pacientesTable').DataTable();
} );



$(document).on("click",".whatsapp", function (event) {

    phone = "569"+event.target.id.substr(event.target.id.length - 8)
    link = "https://web.whatsapp.com/send?phone="+phone+"&text=Hola%20"
    console.log(link)
    window.open(link, "_blank");
    var message = $.trim($("#message").val());
        if(message != ""){
            window.open(link, "_blank");
        }
});
