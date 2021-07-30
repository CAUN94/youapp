var table = $('#pacientesTable');
table.find("tbody tr").remove();
pacientes.forEach(function (paciente) {
    if('No confirmado' == paciente['Estado'] || 'Agenda Online' == paciente['Estado']){
        nombre = paciente['Nombre_paciente'] + " " +paciente["Apellidos_paciente"]
        nr = paciente['Tratamiento_Nr']
        paciente['Celular'] = paciente['Celular'].toString()
        paciente['Celular'] = paciente['Celular'].replace(/ /g,'')
        hora = paciente['Hora_inicio'].slice(0, -3)
        profesional = paciente['Profesional'].replace(/\s/g,'%20')
        precio = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(paciente['TotalAtencion'])
        precio = precio.replace(/\s/g,'%20')
        phone = "569"+ paciente['Celular'].substr(paciente['Celular'].length - 8);
        mail = "<a href=mailto:"+paciente['Mail']+">"+paciente['Mail']+"</a>"
        var d = new Date(paciente['Fecha']);
        var dayName = d.toString().split(' ')[0];
        if ( dayName == 'Mon'){
            texto = 'Hola '+paciente['Nombre_paciente']+'! Te recordamos que tienes atención el lunes con '+profesional+' a las '+hora+' hrs.'
        } else {
            texto = 'Hola '+paciente['Nombre_paciente']+'! Te recordamos que tienes atención mañana con '+profesional+' a las '+hora+' hrs.'
        }


        if(paciente['TotalAtencion']!=0){
            texto += '--No olvides pagar antes de tu atención en el siguiente link http://yjb.cl/pago. El monto a pagar es de '+precio
        }

        if ((paciente['TotalAtencion'] == 40000 || paciente['TotalAtencion'] == 35000 || paciente['TotalAtencion'] == 35000*80/100 || paciente['TotalAtencion'] == 45000*80/100) && paciente['Profesional'] == "Melissa Ross Guerra"){
            texto += "%0A%0ALa%20Nutricionista%20Melissa%20solicita%20llenar%20la%20siguiente%20encuesta%20para%20facilitar%20el%20proceso:%0Ahttps://docs.google.com/forms/d/1mp5OTanOpuyFlWvzInIW3oM5pnxUz8kbWoaNAsDlXWY/edit?usp=sharing"
        }

        texto += '--Adjuntamos documento que se solicita en comisaria virtual para obtención de salvoconducto.%0Ahttp://justbetter.cl/youapp/public/pdf/'+nr
        texto += '--Trae ropa cómoda, estamos en San pascual 736, Las Condes--Avisar en caso de haber presentado algún síntoma en los últimos 14 días'

        texto = texto.replace(/\--/g,'%0A%0A')
        texto = texto.replace(/\s/g,'%20')
        whatsapp = "https://web.whatsapp.com/send?phone="+phone+"&text="+texto

        link = "<a href='"+whatsapp+"' target='_blank'>+"+phone+"</a><br><a href='/pdf/"+nr+"' target='_blank'>Permiso PDF</pdf></a>"
        table.append("<tr><td>" + nombre + "</td><td>" + mail +  "</td><td>"  + link + "</td></tr>");
    }
});
$('td a').click(function(){
    $(this).parent().parent().addClass('bg-warning')
});
