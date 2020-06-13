class Table {

    // Constructor
    constructor(struct, data) {
        this.struct = struct;
        this.data = data;
    }

    // Public methods  
    createTable() {

        let html = "";
        let field = "";        
        let struct = '';
        let data = '';

        struct = JSON.parse(this.struct);
        data = JSON.parse(this.data);        
        
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
    }
}
