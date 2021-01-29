$("#card").hide();
var selectedFile
console.log(window.XLSX);
document.getElementById('input').addEventListener("change", function(event) {
    selectedFile = event.target.files[0];
})

var data=[{
    "name":"jayanth",
    "data":"scd",
    "abc":"sdef"
}]


document.getElementById('button').addEventListener("click", function() {
    XLSX.utils.json_to_sheet(data, 'out.xlsx');
    if(selectedFile){
        var fileReader = new FileReader()
        fileReader.readAsBinaryString(selectedFile);
        var allRows = []
        fileReader.onload = function(event) {
         var data = event.target.result
         var workbook = XLSX.read(data,{type:"binary",cellDates:true});
         console.log(workbook)

         workbook.SheetNames.forEach(function(sheet) {
            var rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
            allRows.push(rowObject)
         });
        // Code
        var profesionales = new Set()
        actions = []
        allRows.forEach(function(element) {
            element.forEach(function(action) {
                actions.push(action)
                profesionales.add(action['Realizado por'])
            });

        });

        var resumen = []
        profesionales.forEach(function(profesional){
            var info = {
                'nombre': profesional,
                'sueldo': 0,
                'citas': 0,
                'atenciones': [],

            }
            actions.forEach(function(action) {

                if (profesional == action['Realizado por']){

                    if(info.atenciones.length == 0){
                        info.sueldo += action['Abonado']
                        info.citas += 1
                        atencion = {
                            'id' : action['# Tratamiento'],
                            'nombre' : action['Nombre paciente'],
                            'apellido' : action['Apellidos paciente'],
                            'estado': action['Estado de la consulta'],
                            'fecha': action['Fecha Realizacion'],
                            'prestación': [action['Nombre Prestacion']],
                            'abonado': [action['Abonado']]
                        }
                        info.atenciones.push(atencion)
                    }
                    else if(action['# Tratamiento'] == info.atenciones[info.atenciones.length-1]['id']){
                        info.sueldo += action['Abonado']
                        info.atenciones[info.atenciones.length-1]['prestación'].push(action['Nombre Prestacion'])
                        info.atenciones[info.atenciones.length-1]['abonado'].push(action['Abonado'])
                    }
                    else {
                        info.sueldo += action['Abonado']
                        info.citas += 1
                        atencion = {
                            'id' : action['# Tratamiento'],
                            'nombre' : action['Nombre paciente'],
                            'apellido' : action['Apellidos paciente'],
                            'estado': action['Estado de la consulta'],
                            'fecha': action['Fecha Realizacion'],
                            'prestación': [action['Nombre Prestacion']],
                            'abonado': [action['Abonado']]
                        }
                        info.atenciones.push(atencion)
                    }



                }
            });
            resumen.push(info)
        });

        console.log(resumen)

        var table = $('#profesionalesTable');

        table.find("tbody tr").remove();

        for (var i = 0; i < resumen.length; i++) {
            var element = resumen[i];
            table.append("<tr><td>" + element['nombre'] + "</td><td>" + element['sueldo'] +  "</td><td>"  + element['citas'] + "</td><td> <a class='link' href='#' id='"+ i + "'>Ver Más</a></td></tr>");
        }

        $(".link").click(function(){
            $("#card").show();
        });

        $("#card-link").click(function(){
            $("#card").hide();
        });




        }


    }
});
