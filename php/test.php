<html>
<head>    
<title>UI</title>
</head>    
<body>

    <script src="../js/moment.js"></script>
    
    <script>

    function formatNumber(value) {

        let format = "";

        if (field("_LANGUAGE_").value == 1) {
            format = "pt-BR";
        } else {
            format = "en-US";
        }

        let x = new Intl.NumberFormat(format).format(number);

        return x;
    }

    alert(formatNumber("1000000.23"));

    </script>        
    
    
    

</body>
</html>
        
        