class Form {

    // Constructor
    constructor(id) {
        this.id = id;
    }

    // Generate form
    createForm() {
        
        let html = "";
        let fieldLabel = '';
        let fieldName = '';
        let fieldType = '';
        let fieldValue = '';
        let struct = '';
        let data = '';
        let http = new HTTPService();
        let element = new HTMLElement();

        // Prepare table html
        try {

            // Get data from database
            struct = http.query('struct');
            data = http.query('data');

            // Conver to json array    
            struct = JSON.parse(struct);
            data = JSON.parse(data);            

            html += `<form id="form1">`;
            for (let i in struct) {
                fieldLabel = struct[i].field_label;
                fieldName = struct[i].field_name;
                if (data.length > 0)
                    fieldValue = data[0][fieldName];
                html += element.createLabel(fieldLabel, fieldName);
                html += element.createTextbox(fieldName, fieldValue, '', false);
                html += '<br>';
            }
            html += `</form>`;
            return html;

        } catch (err) {
            return err.message;
        }
    }
}