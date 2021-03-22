var table = $('#pacientesTable');
table.find("tbody tr").remove();
pacientes.forEach(function (paciente) {
    if('No confirmado' == paciente["status"] || 'Agenda Online' == paciente["status"]){
        nombre = paciente["name"] + " " +paciente["lastnames"]
        paciente["phone"] = paciente["phone"].toString().replace(/ /g,'')
        hora = paciente["hour"].slice(0, -3)
        precio = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(paciente["benefit"])
        phone = "569"+ paciente["phone"].substr(paciente["phone"].length - 8);
        mail = "<a href=mailto:"+paciente["email"]+">"+paciente["email"]+"</a>"
        whatsapp = "https://web.whatsapp.com/send?phone="+phone+"&text=Hola%20"+paciente["name"]+"!%20Te%20recordamos%20que%20tienes%20atención%20mañana%20con%20"+paciente['professional']+"%20a%20las%20"+hora+"%20hrs."
        console.log(precio)
        if(paciente["benefit"]!=0){
            whatsapp += "%0A%0ANo%20olvides%20pagar%20antes%20de%20tu%20atención%20con%20transferencia%20o%20con%20tarjeta%20en%20https://pagatuprofesional.cl/profesionales/you-spa%0A%0AEl monto a pagar es de "+precio
        }

        whatsapp +="%0A%0ATrae%20ropa%20cómoda,%20estamos%20en%20el%20Omnium,%20Av%20Apoquindo%204.900%20Loc%207%20y%208%20!%0A%0AAvisar%20en%20caso%20de%20haber%20presentado%20algún%20síntoma%20en%20los%20últimos%2014%20días%0A%0A"


        link = "<a href='"+whatsapp+"' target='_blank'>+"+phone+"</a>"
        table.append("<tr><td>" + nombre + "</td><td>" + mail +  "</td><td>"  + link + "</td></tr>");
    }
});
$('td a').click(function(){
    console.log(2)
    $(this).parent().parent().addClass('bg-warning')
});
