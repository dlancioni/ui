class HTTPService {

    constructor() {
    }

    persist(str) {
        let url = "api/src/query.php?param=" + str;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('POST', url, false);
        xmlhttp.setRequestHeader("Content-Type", "text/plain, charset=UTF-8");
        xmlhttp.send(null);
        if (xmlhttp.status == 200) {
            return xmlhttp.responseText;
        }
    }

    // Query Data
    query(str) {
        let url = "api/src/query.php?param=" + str;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', url, false);
        xmlhttp.setRequestHeader("Content-Type", "text/plain, charset=UTF-8");
        xmlhttp.send(null);
        if (xmlhttp.status == 200) {
            return xmlhttp.responseText;
        }
    }
}