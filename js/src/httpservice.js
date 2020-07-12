class HTTPService {

    constructor(systemId, tableId, userId, languageId) {
        this.systemId = systemId;
        this.tableId = tableId;
        this.userId = userId;
        this.languageId = languageId;
    }

    // Query Data
    getTableDef(systemId, tableId) {

        // General declaration
        let url = "";
        let tableDef = "[]";

        // Prepare API call
        url = `api/tabledef.php?system=${systemId}&table=${tableId}`;

        // Just call it
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', url, false);
        xmlhttp.setRequestHeader("Content-Type", "text/plain, charset=UTF-8");
        xmlhttp.send(null);

        // Handle status
        if (xmlhttp.status == 200) {
            tableDef = JSON.parse(xmlhttp.responseText);
            if (tableDef.length > 0) {
                localStorage.table = tableDef[0].table_name;
            }
        }

        // Return def
        return tableDef;
    }

    // Query Data
    query(systemId, tableId, filter) {

        // General declaration
        let url = "";

        // Set table Id
        this.tableId = tableId;

        // Prepare API call
        url = `api/query.php?system=${this.systemId}&table=${this.tableId}&user=${this.userId}&language=${this.languageId}&filter=` + filter;

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