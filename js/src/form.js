class Form {

    // Constructor
    constructor(id) {
        this.id = id;
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
        let filter = "";
        let http = new HTTPService();
        let element = new HTMLElement();

        try {
            // Get table structure
            let filter = `[{"table":"tb_field","field":"id_table","type":"int","operator":"=","value":${this.id},"mask":""}]`;
            tableDef = http.query(3, filter);

            // Get data
            filter = '[]';            
            data = http.query(this.id, "");

            // Conver to json array    
            tableDef = JSON.parse(tableDef);
            data = JSON.parse(data);            

            // Create main form
            html += `<form id="form1">`;
            for (let i in tableDef) {
                fieldLabel = tableDef[i].label;
                fieldName = tableDef[i].name;
                if (data.length > 0)
                    fieldValue = data[0][fieldName];
                html += element.createLabel(fieldLabel, fieldName);
                html += element.createTextbox(fieldName, fieldValue, '', false);
                html += '<br>';
            }
            html += `</form>`;

            // Return form
            return html;

        } catch (err) {
            return err.message;
        }
    }
}