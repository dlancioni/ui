
function go(table=0, style=1) {
    // Table destination
    document.getElementById("_TABLE_").value = table;
    // 1) Report, 2) Form
    document.getElementById("_STYLE_").value = style;
    // Just go
    document.form1.submit();
}