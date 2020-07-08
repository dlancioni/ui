class Table {

    // Constructor
    constructor(id) {
        this.id_table = id;
    }

    // Public methods  
    createTable() {

        let html = "";
        let cols = "";
        let rows = "";
        let fieldName = "";        
        let tableDef = '';
        let data = '';
        let events = "";
        let http = new HTTPService();
        let element = new HTMLElement();
        let filter = "";
        let checked = "checked";

        try {

            // Get table structure
            tableDef = http.getTableDef(localStorage.system, this.id_table);

            // Get data
            filter = new Filter();
            data = JSON.parse(http.query(this.id_table, filter.create()));

            // Get controls (events)
            filter = new Filter();
            filter.add("tb_event", "id_table", this.id_table);
            filter.add("tb_event", "id_target", 1);
            events = JSON.parse(http.query(5, filter.create()));

            // Prepare table html
            cols = element.createTableHeader('');
            for (let i in tableDef) {
                cols += element.createTableHeader(tableDef[i].field_label);
            }
            rows += element.createTableRow(cols);

            // Prepare table contents
            for (let i in data) {
                cols = '';
                cols += element.createTableCol(element.createRadio("selection", data[i]['id'], checked, "onClick='setId(this.value)'"));
                checked != "" ? localStorage.id = data[i]['id'] : ""; checked = "";
                for (let j in tableDef) {
                    fieldName = tableDef[j].field_name;
                    cols += element.createTableCol(data[i][fieldName]);
                }
                rows += element.createTableRow(cols);
            }

            // Finalize table    
            html += element.createTable(rows);

            // Add controls
            html += `<br>`;
            for (let i in events) {
                html += element.createButton(events[i].label, events[i].label, events[i].id_event + "=" + events[i].code);
            }            

            // Return it
            return html;

        } catch (err) {
            return "createTable():" + err.message;
        }        
    }
}
