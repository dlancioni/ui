class Form {

    // Constructor
    constructor(id) {
        this.id_table = id;
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
        let filter = new Filter();

        try {

            // Get table structure
            tableDef = http.getTableDef(localStorage.system, this.id_table);

            // Get data
            data = JSON.parse(http.query(this.id_table, '[]'));

            // Get controls (events)
            filter.add("tb_event", "id_table", this.id_table);
            filter.add("tb_event", "id_target", 2);
            events = JSON.parse(http.query(5, filter.create()));

            // Create main form
            html += `<form id="form1">`;
            for (let i in tableDef) {
                fieldLabel = tableDef[i].field_label;
                fieldName = tableDef[i].field_name;
                if (data.length > 0)
                    fieldValue = data[0][fieldName];
                html += element.createLabel(fieldLabel, fieldName);
                html += element.createTextbox(fieldName, fieldValue, '', false);
                html += '<br>';
            }
            html += `</form>`;

            // Add controls
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