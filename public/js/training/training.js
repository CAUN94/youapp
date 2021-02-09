document.getElementById('input').addEventListener("change",function (event){
    selectedFile = event.target.files[0]
})

var data=[{
    "name":"jayanth",
    "data":"scd",
    "abc":"sdef"
}]


function whatsapp(persona){

    var name = persona.Nombre+" "+persona['Apellidos (Ingresar ambos)']
    var words = name.split(" ")

    for (var i = 0; i < words.length; i++) {
        words[i] = words[i][0].toUpperCase() + words[i].substr(1)
    }

    name = words.join(" ")

    var first_name= persona.Nombre
    words = first_name.split(" ")

    for (var i = 0; i < words.length; i++) {
        words[i] = words[i][0].toUpperCase() + words[i].substr(1)
    }

    first_name= words.join(" ")
    
    persona['Teléfono'] = persona['Teléfono'].toString()
    persona['Teléfono'] = persona['Teléfono'].replace(/ /g,'')
    phone = "569"+ persona['Teléfono'].substr(persona['Teléfono'].length - 8)

    mail = "<a href=mailto:"+persona['Mail']+">"+persona['Mail']+"</a>"

    var dateObj = persona['Fecha Termino']
    var month = dateObj.getMonth() + 1 
    var day = dateObj.getDate()
    var year = dateObj.getFullYear()

    newdate =  day + " - " + month

    url = "https://web.whatsapp.com/send?phone="+phone+"&text=Hola%20"+first_name+
    "%0A%0ATe%20queríamos%20recordar%20que%20tu%20suscripcion%20del%20tipo%20"+persona["Tipo de Suscripción"]+"%20terminó%20el%20"+newdate+",%0Ano%20olvides%20renovarla%20en%20caso%20de%20que%20quieras%20seguir%20entrenando.%0A%0Asaludos,%0A%0AEquipo%20You"

    link = "<a href='"+url+"' target='_blank'>+"+phone+"</a>"

    table.append("<tr><td>" + name + "</td><td>" + mail +  "</td><td>"  + link + "</td></tr>")
}

var rowObject = new Array()
var list 
var table = $('#studentsTable')
table.find("tbody tr").remove()
document.getElementById('button').addEventListener("click", function() {
    XLSX.utils.json_to_sheet(data, 'out.xlsx')
    if(selectedFile){
        var fileReader = new FileReader()
        fileReader.readAsBinaryString(selectedFile)
        fileReader.onload = function(event){
            var data = event.target.result
            var workbook = XLSX.read(data,{type:"binary",cellDates:true})
             workbook.SheetNames.forEach(function(sheet) {
                list = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet])
                list.forEach(function(element) {
                    rowObject.push(element)
                })
             })


             //Here goes the code
             rowObject.forEach(function(element) {
                 if ('Marca temporal' in element && element["Días que Quedan"]<=0){
                    whatsapp(element)
                 }
                 
             })
             $('a').click(function(){
                console.log(2)
                $(this).parent().parent().addClass('bg-warning')
            })
        }
        
    }
})


