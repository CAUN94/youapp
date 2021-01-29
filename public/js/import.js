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
        fileReader.readAsBinaryString(selectedFile)
        fileReader.onload = function(event){
            var data = event.target.result;
            var workbook = XLSX.read(data,{type:"binary",cellDates:true});
             console.log(workbook)
             workbook.SheetNames.forEach(function(sheet) {
                  var rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                  console.log(rowObject)
                  document.getElementById("jsondata").innerHTML = JSON.stringify(rowObject,undefined,4)
             });
        }
    }
});
