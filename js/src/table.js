class Table {

    // Constructor
    constructor() {
    }

    // Public methods  
    createTable() {

        let html = "";
        let cols = "";
        let rows = "";
        let field = "";        
        let struct = '';
        let data = '';
        let http = new HTTPService();
        let element = new HTMLElement();

        try {

            // Get data from database
            struct = http.query(3);
            data = http.query(2);

            // Conver to json array    
            struct = JSON.parse(struct);
            data = JSON.parse(data);

            // Prepare table html
            cols = element.createTableHeader('');
            for (let i in struct) {
                cols += element.createTableHeader(struct[i].field_label);
            }
            rows += element.createTableRow(cols);

            // Prepare table contents
            for (let i in data) {
                cols = '';
                cols += element.createTableCol(element.createRadio("selection", "selection", false));
                for (let j in struct) {
                    field = struct[j].field_name;
                    cols += element.createTableCol(data[i].field[field]);
                }
                rows += element.createTableRow(cols);
            }

            html += element.createTable(rows);

            return html;            

        } catch (err) {
            return "createTable():" + err.message;
        }        
    }
}
