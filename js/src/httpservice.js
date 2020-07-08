class HTTPService {

    constructor() {
    }

    // Query Data
    getTableDef(system, table) {

        // General declaration
        let url = "";
        let tableDef = "[]";

        // Prepare API call
        url = `api/tabledef.php?system=${system}&table=${table}`;

        // Just call it
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', url, false);
        xmlhttp.setRequestHeader("Content-Type", "text/plain, charset=UTF-8");
        xmlhttp.send(null);

        // Handle status
        if (xmlhttp.status == 200) {
            tableDef = JSON.parse(xmlhttp.responseText);
            if (tableDef.length > 0) {
                localStorage.tableName = tableDef[0].table_name;
            }
        }

        // Return def
        return tableDef;
    }

    // Query Data
    query(tableId, filter) {

        // General declaration
        let url = "";
        let systemId = parseInt(localStorage.system);
        let userId = parseInt(localStorage.user);
        let languageId = parseInt(localStorage.language);

        // Prepare API call
        url = `api/query.php?system=${systemId}&table=${tableId}&user=${userId}&language=${languageId}&filter=` + filter;

        // Just call it
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', url, false);
        xmlhttp.setRequestHeader("Content-Type", "text/plain, charset=UTF-8");
        xmlhttp.send(null);

        // Handle status
        if (xmlhttp.status == 200) {
            return xmlhttp.responseText;
        }
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


}