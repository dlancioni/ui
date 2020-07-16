class HTTPService {

    // Constructor (not used)
    constructor() {
    }

    // Query Data
    query(data="") {

        // General declaration
        let url = "./php/query.php?data=" + data;

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

    persist(data="") {

        // General declaration
        let url = "./php/persist.php?data=" + data;

        // Just call it
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", url, false);
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