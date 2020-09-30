class HTTPService {

    // Constructor (not used)
    constructor() {
    }

    // Query database
    query (param) {

        // General declaration
        let url = "./php/query.php?param=" + param;

        // Just call it
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", url, false);
        xmlhttp.setRequestHeader("Content-Type", "text/plain, charset=UTF-8");
        xmlhttp.send(null);

        // Handle status
        if (xmlhttp.status == 200) {
            return xmlhttp.responseText;
        } else {
            return xmlhttp.status;
        }
    }

    persist (formData) {

        // General declaration
        let url = "./php/persist.php?" + formData;
        alert(url);

        // Just call it
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", url, false);
        xmlhttp.setRequestHeader("Content-Type", "text/plain, charset=UTF-8");
        xmlhttp.send();

        // Handle status
        if (xmlhttp.status == 200) {
            return xmlhttp.responseText;
        } else {
            return xmlhttp.status;
        }
    }

    // Query database
    execute (url) {

        url = "./php/" + url;

        // Just call it
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", url, false);
        xmlhttp.setRequestHeader("Content-Type", "text/plain, charset=UTF-8");
        xmlhttp.send(null);

        // Handle status
        if (xmlhttp.status == 200) {
            return xmlhttp.responseText;
        } else {
            return xmlhttp.status;
        }
    }

}