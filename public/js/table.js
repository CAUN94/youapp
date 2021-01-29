var table = $('#pacientesTable');
table.find("tbody tr").remove();
pacientes.forEach(function (paciente) {
    paciente['Celular'] = paciente['Celular'].replace(/ /g,'')
    nombre = paciente['Nombre paciente'] + " " +paciente["Apellidos paciente"]
    phone = "569"+ paciente['Celular'].substr(paciente['Celular'].length - 8);
    mail = "<a href=mailto:"+paciente['E-Mail']+">"+paciente['E-Mail']+"</a>"
    link = "<a href='#' class='whatsapp' id="+phone+">+"+phone+"</a>"



    table.append("<tr><td>" + nombre + "</td><td>" + paciente['RUT/DNI'] + "</td><td>" + paciente['Sexo'] + "</td><td>" + mail + "</td><td>" + link + "</td></tr>");
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

