class Form {

    // Constructor
    constructor(systemId, tableId, userId, languageId) {
        this.systemId = systemId;
        this.tableId = tableId;
        this.userId = userId;
        this.languageId = languageId;
    }

    // Generate form
    createForm() {

        let html = "";
        let fieldLabel = "";
        let fieldName = "";
        let fieldType = "";
        let fieldValue = "";
        let tableDef = "";
        let data = "";
        let events = "";
        let http = new HTTPService();
        let element = new HTMLElement();
        let filter = "";

        try {

            // New http session            
            http = new HTTPService(this.systemId, this.tableId, this.userId, this.languageId);

            // Get table structure
            tableDef = http.getTableDef(this.systemId, this.tableId);

            // Get data
            filter = new Filter();
            filter.add(this.tableId, "id", localStorage.id);
            data = JSON.parse(http.query(this.systemId, this.tableId, filter.create()));

            // Create main form
            html += `<form id="form1">`;
            for (let i in tableDef) {
                fieldLabel = tableDef[i].field_label;
                fieldName = tableDef[i].field_name;
                if (data.length > 0)
                    fieldValue = data[0][fieldName];
                html += element.createLabel(fieldLabel, fieldName);
                if (tableDef[i]["field_fk"] == 0) {
                    html += element.createTextbox(fieldName, fieldValue, '', false);
                } else {
                    data = JSON.parse(http.query(tableDef[i]["field_fk"], '[]'));
                    html += element.createDropdown(fieldName, fieldValue, data);
                }
                html += '<br>';
            }
            html += `</form>`;

            // Get controls (events)
            filter = new Filter();
            filter.add("tb_event", "id_table", this.tableId);
            filter.add("tb_event", "id_target", 2);
            events = JSON.parse(http.query(5, filter.create()));

            html += `<br>`;
            for (let i in events) {
                html += element.createButton(events[i].label, events[i].label, events[i].id_event + "=" + events[i].code);
            }

            // Return form
            return html;

        } catch (err) {
            return err.message;
        }
    }
}