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
        let filter = "";
        let http = new HTTPService();
        let element = new HTMLElement();

        try {

            // Get table structure
            tableDef = http.getTableDef(localStorage.system, this.id_table);

            // Get data
            filter = '[]';            
            data = JSON.parse(http.query(this.id_table, filter));

            // Get controls (events)
            filter = "[";
            filter += `{"table":"tb_event","field":"id_table","type":"int","operator":"=","value":${this.id_table},"mask":""},`;
            filter += `{"table":"tb_event","field":"id_target","type":"int","operator":"=","value":2,"mask":""}`;
            filter += "]";
            events = JSON.parse(http.query(5, filter));

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