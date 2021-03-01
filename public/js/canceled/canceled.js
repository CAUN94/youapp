var table = $('#canceledTable');

table.find("tbody tr").remove();
canceled.forEach(function (paciente) {
    paciente['Celular'] = paciente['Celular'].replace(/ /g,'')
    nombre = paciente['Nombre_paciente'] + " " +paciente["Apellidos_paciente"]
    phone = "569"+ paciente['Celular'].substr(paciente['Celular'].length - 8);
    fecha = paciente['Max(Fecha)'].slice(0, 10)+" "+paciente['Hora_inicio']
    estado = paciente['Estado']
    profesional = paciente['Profesional']
    mail = "<a href=mailto:"+paciente['Mail']+">"+paciente['Mail']+"</a>"
    link = "<a href='#' class='whatsapp' id="+phone+">+"+phone+"</a>"
    table.append("<tr><td>" + nombre + "</td><td>" + fecha + "</td><td>" + estado + "</td><td>" + profesional + "</td><td>" + mail + "</td><td>" + link + "</td></tr>");
});

$(document).ready( function () {
    $('#canceledTable').DataTable();
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
