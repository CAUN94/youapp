document.getElementById('input').addEventListener("change",function (event){
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
         var workbook = XLSX.read(data,{type:"binary"});
         console.log(workbook)

         workbook.SheetNames.forEach(function(sheet) {
            var rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
            allRows.push(rowObject)
         });
        // Code
        var pacientes = new Set()
        actions = []
        allRows.forEach(function(element) {
            element.forEach(function(action) {
                actions.push(action)
                pacientes.add(action['Rut Paciente'])
            });

        });

        var resumen = []
        pacientes.forEach(function(paciente){
            
            var info = {
                'rut': paciente,
                'nombre': null,
                'apellido': null,
                'ultima': [],

            }
            actions.forEach(function(action) {
                if(typeof(action['Fecha Cita']) == "number" ){
                    
                    function date_format(transform){
                        var month = transform.getDate() +1
                        var day = transform.getMonth() + 1
                        var year = transform.getFullYear().toString().slice(-2)

                        if(month < 10){
                            // newdate = `${day}-0${month}-${year}`
                        }else{
                            // newdate = `${day}-${month}-${year}`
                        }

                        return  newdate
                    }

                    hoy = new Date()
                    date = new Date(Math.round((action['Fecha Cita'] - 25569)*86400*1000));
                    action['Fecha Cita'] = date_format(date)
                    hoy = date_format(hoy)
                }
                

                if (paciente == action['Rut Paciente']){
                                        
                    info.nombre = action["Nombre paciente"]
                    info.apellido = action["Apellidos paciente"]
                    info.ultima.push([action["Profesional"],action["Estado Cita"],action["Fecha Cita"]])

                }

            });
            resumen.push(info)
        });

        // console.log(resumen)

        resumen.forEach(function(element) {
            estado = element['ultima'][0]
            if(estado[1] == 'Anulado' || estado[1] == 'No Asiste'){
                console.log(element)
            }
            
            
        });

        // var table = $('#pacientesTable');

        // table.find("tbody tr").remove();

        // for (var i = 0; i < resumen.length; i++) {
        //     var element = resumen[i];
        //     table.append("<tr><td>" + element['nombre'] + "</td><td>" + element['sueldo'] +  "</td><td>"  + element['citas'] + "</td><td> <a class='link' href='#' id='"+ i + "'>Ver Más</a></td></tr>");
        // }

        // $(".link").click(function(){
        //     $("#card").show();
        // });

        // $("#card-link").click(function(){
        //     $("#card").hide();
        // });




        }


    }
});


