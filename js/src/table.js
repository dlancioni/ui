class Table {

    // Constructor
    constructor(struct, data) {
        this.struct = struct;
        this.data = data;
    }

    // Public methods  
    do() {

        let html = "";
        let field = "";
        let struct = JSON.parse(this.struct);
        let data = JSON.parse(this.data);
        html += "<table>";
        
        // Prepare table html
        html += "<tr>";
        for (let i in struct) {
          html += "<th>" + struct[i].field_label + "</th>";          
        }
        html += "</tr>";

        // Prepare table contents
        html += "<tr>";
        for (let i in data) {
          for (let j in struct) {
            field = struct[j].field_name;
            html += "<td>" + data[i][field] + "</td>";
          }
        }
        html += "</tr>";        
        html += "</table>";

        return html;
    }
}  

module.exports = {
  Table
};
