class Form {

    // Constructor
    constructor(struct, data) {
        this.struct = struct;
        this.data = data;
    }

    // Create new label
    createLabel(label='', name='') {

        let html = '';

        try {
            html += `<label for="${name}">${label}</label>`;
            return html.trim();
        } catch (err) {
            return err.message;
        }
    }

    // Create textbox
    createTextbox(label='', name='', value='', placeholder='', disabled=false) {

        let html = '';

        try {
            html += `<input`;
            html += ` type="text"`;
            html += ` id="${name}"`; 
            html += ` name="${name}"`; 
            html += ` value="${value}"`;
            if (placeholder != '')
                html += ` placeholder="${placeholder}"`;
            if (disabled) html += ` disabled`;
                html += '>';
            return html.trim();

        } catch (err) {
            return err.message;
        }
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
        
        // Prepare table html
        try {

            struct = JSON.parse(this.struct);
            data = JSON.parse(this.data);            

            html += `<form id="form1">`;
            for (let i in struct) {
                fieldLabel = struct[i].field_label;
                fieldName = struct[i].field_name;
                if (data.length > 0)
                    fieldValue = data[0][fieldName];
                html += this.createLabel(fieldLabel, fieldName);
                html += this.createTextbox(fieldName, fieldValue, '', false);
                html += '<br>';
            }
            html += `</form>`;
            return html;

        } catch (err) {
            return err.message;
        }
    }
}