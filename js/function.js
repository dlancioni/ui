

function go(table=0,style=1) {
    
    document.getElementById("table").value = table;
    document.getElementById("style").value = style;
    alert(document.getElementById("style").value);

    document.form1.submit();
}