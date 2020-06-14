class Table {

    // Constructor
    constructor(id) {
        this.id = id;
    }

    // Public methods  
    createTable() {

        let html = "";
        let field = "";        
        let struct = '';
        let data = '';
        let http = new HTTPService();

        try {

            // Get data from database
            struct = http.query('struct');
            data = http.query('data');

            // Conver to json array    
            struct = JSON.parse(struct);
            data = JSON.parse(data);

            // Prepare table html
            html += "<table>";        
            html += "<tr>";
            for (let i in struct) {
                html += "<th>" + struct[i].field_label + "</th>";          
            }
            html += "</tr>";

            // Prepare table contents
            for (let i in data) {
                html += "<tr>";
                for (let j in struct) {
                    field = struct[j].field_name;
                    html += "<td>" + data[i].field[field] + "</td>";
                }
                html += "</tr>";
            }
            html += "</table>";
            return html;            

        } catch (err) {
            return err.message;
        }        
    }
}
