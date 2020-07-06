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
    query(code, filter) {
        let url = "api/query.php?system=1&user=1&language=1&table=" + code + "&filter=" + filter;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', url, false);
        xmlhttp.setRequestHeader("Content-Type", "text/plain, charset=UTF-8");
        xmlhttp.send(null);
        if (xmlhttp.status == 200) {
            return xmlhttp.responseText;
        }
    }
}