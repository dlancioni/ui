class Table {

    // Constructor
    constructor(id) {
        this.id = id;
    }

    // Public methods  
    createTable() {

        let html = "";
        let cols = "";
        let rows = "";
        let fieldName = "";        
        let tableDef = '';
        let data = '';
        let http = new HTTPService();
        let element = new HTMLElement();
        let filter = "";

        try {

            // Get table structure
            let filter = `[{"table":"tb_field","field":"id_table","type":"int","operator":"=","value":${this.id},"mask":""}]`;
            tableDef = http.query(3, filter);

            // Get data
            filter = '[]';
            data = http.query(this.id, filter);

            // Conver to json array    
            tableDef = JSON.parse(tableDef);
            data = JSON.parse(data);

            // Prepare table html
            cols = element.createTableHeader('');
            for (let i in tableDef) {
                cols += element.createTableHeader(tableDef[i].label);
            }
            rows += element.createTableRow(cols);

            // Prepare table contents
            for (let i in data) {
                cols = '';
                cols += element.createTableCol(element.createRadio("selection", "selection", false));
                for (let j in tableDef) {
                    fieldName = tableDef[j].name;
                    cols += element.createTableCol(data[i][fieldName]);
                }
                rows += element.createTableRow(cols);
            }

            // Finalize table    
            html += element.createTable(rows);

            // Return it
            return html;

        } catch (err) {
            return "createTable():" + err.message;
        }        
    }
}
