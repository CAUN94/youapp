var table = $('#pacientesTable');
table.find("tbody tr").remove();
pacientes.forEach(function (paciente) {
    if('No confirmado' == paciente['Estado'] || 'Agenda Online' == paciente['Estado']){
        nombre = paciente['Nombre_paciente'] + " " +paciente["Apellidos_paciente"]
        nr = paciente['Tratamiento_Nr']
        paciente['Celular'] = paciente['Celular'].toString()
        paciente['Celular'] = paciente['Celular'].replace(/ /g,'')
        hora = paciente['Hora_inicio'].slice(0, -3)
        precio = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(paciente['TotalAtencion'])
        phone = "569"+ paciente['Celular'].substr(paciente['Celular'].length - 8);
        mail = "<a href=mailto:"+paciente['Mail']+">"+paciente['Mail']+"</a>"
        whatsapp = "https://web.whatsapp.com/send?phone="+phone+"&text=Hola%20"+paciente['Nombre_paciente']+"!%20Te%20recordamos%20que%20tienes%20atención%20mañana%20con%20"+paciente['Profesional']+"%20a%20las%20"+hora+"%20hrs."
        console.log(nombre)
        console.log(paciente['TotalAtencion'])
        console.log(paciente['Profesional'])
        if(paciente['TotalAtencion']!=0){
            whatsapp += "%0A%0ANo%20olvides%20pagar%20antes%20de%20tu%20atención%20con%20transferencia%20o%20con%20tarjeta%20en%20https://pagatuprofesional.cl/profesionales/you-spa%0A%0AEl monto a pagar es de "+precio
        }

        if ((paciente['TotalAtencion'] == 45000 || paciente['TotalAtencion'] == 40000 || paciente['TotalAtencion'] == 40000*80/100 || paciente['TotalAtencion'] == 45000*80/100) && paciente['Profesional'] == "Renata Barchiesi Vitali"){

            whatsapp += "%0A%0ALa%20Dra.%20Barchiechi%20pide%20llenar%20esta%20encuesta%20para%20facilitar%20el%20proceso%20de%20consulta:%0Ahttps://docs.google.com/forms/d/e/1FAIpQLSdDyQNCXglp19ymu2dMbpexlNUkel8-wzbafpDnkijzvWwXrA/viewform?usp=sf_link"
        }

        if ((paciente['TotalAtencion'] == 40000 || paciente['TotalAtencion'] == 35000 || paciente['TotalAtencion'] == 35000*80/100 || paciente['TotalAtencion'] == 45000*80/100) && paciente['Profesional'] == "Melissa Ross Guerra"){
            whatsapp += "%0A%0ALa%20Nutricionista%20Melissa%20solicita%20llenar%20la%20siguiente%20encuesta%20para%20facilitar%20el%20proceso:%0Ahttps://docs.google.com/forms/d/1mp5OTanOpuyFlWvzInIW3oM5pnxUz8kbWoaNAsDlXWY/edit?usp=sharing"
        }

        whatsapp += "%0A%0AAdjuntamos%20el%20documento%20necesario%20para%20poder%20movilizarse%20en%20fase%201%20http://justbetter.cl/youapp/public/pdf/"+nr

        whatsapp +="%0A%0ATrae%20ropa%20cómoda,%20estamos%20en%20el%20Omnium,%20Av%20Apoquindo%204.900%20Loc%207%20y%208%20!%0A%0AAvisar%20en%20caso%20de%20haber%20presentado%20algún%20síntoma%20en%20los%20últimos%2014%20días%0A%0A"



        link = "<a href='"+whatsapp+"' target='_blank'>+"+phone+"</a><br><a href='/pdf/"+nr+"' target='_blank'>Permiso PDF</pdf></a>"
        table.append("<tr><td>" + nombre + "</td><td>" + mail +  "</td><td>"  + link + "</td></tr>");
    }
});
$('td a').click(function(){
    console.log(2)
    $(this).parent().parent().addClass('bg-warning')
});
