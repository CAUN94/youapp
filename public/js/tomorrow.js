var table = $('#pacientesTable');
table.find("tbody tr").remove();
pacientes.forEach(function (paciente) {
    if('No confirmado' == paciente['Estado'] || 'Agenda Online' == paciente['Estado']){
        nombre = paciente['Nombre_paciente'] + " " +paciente["Apellidos_paciente"]
        paciente['Celular'] = paciente['Celular'].toString()
        paciente['Celular'] = paciente['Celular'].replace(/ /g,'')
        phone = "569"+ paciente['Celular'].substr(paciente['Celular'].length - 8);
        mail = "<a href=mailto:"+paciente['Mail']+">"+paciente['Mail']+"</a>"
        whatsapp = "https://web.whatsapp.com/send?phone="+phone+"&text=Hola%20"+paciente['Nombre_paciente']+"%0A%0Acomo estas?%0A%0ATe queríamos recordar que mañana tienes una hora a las: "+paciente['Hora de inicio Cita']+" en nuestra sucursal.%0A%0ATe esperamos.%0AEquipo You"


        whatsapp = "https://web.whatsapp.com/send?phone="+phone+"&text=Hola%20"+paciente['Nombre_paciente']+"!%20Te%20recordamos%20que%20tienes%20atención%20mañana%20con%20"+paciente['Profesional']+"%20a%20las%20"+paciente['Hora de inicio Cita']+"%20hrs.%0A%0ANo%20olvides%20pagar%20antes%20de%20tu%20atención%20con%20transferencia%20o%20con%20tarjeta%20en%20https://pagatuprofesional.cl/profesionales/you-spa%0A%0ATrae%20ropa%20cómoda,%20estamos%20en%20el%20Omnium,%20Av%20Apoquindo%204.900%20Loc%207%20y%208%20!%0A%0AAvisar%20en%20caso%20de%20haber%20presentado%20algún%20síntoma%20en%20los%20últimos%2014%20días%0A%0A"

        // if (paciente['Comentario Cita'] != null && paciente['Comentario Cita'].includes('box')){
        //     whatsapp += "Link%20para%20la%20consulta:%20"+paciente['Comentario Cita']
        // }


        link = "<a href='"+whatsapp+"' target='_blank'>+"+phone+"</a>"

        table.append("<tr><td>" + nombre + "</td><td>" + mail +  "</td><td>"  + link + "</td></tr>");
    }
});
$('a').click(function(){
    console.log(2)
    $(this).parent().parent().addClass('bg-warning')
});
