class HTMLElement {

    // Constructor
    constructor() {
        this.className = 'HTMLElement';
        this.methodName = '';
    }

    errorMessage(className='', methodName='', message='') {
        let msg = '';
        msg = className + '.' + methodName + ': ' + message;
        return msg;
    }
  
    // Create new label
    createLabel(label='', name='') {
        this.methodName = 'createLabel';
        let html = '';
        try {
            html += `<label for="${name}">${label}</label>`;
            return html.trim();
        } catch (err) {
            throw this.errorMessage(this.className, this.methodName, err.message);
        }
    }

    // Create textbox
    createTextbox(label='', name='', value='', placeholder='', disabled=false) {
        this.methodName = 'createTextbox';
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
            throw this.errorMessage(this.className, this.methodName, err.message);
        }
    }
    
    // Create buttons
    createButton(name='', value='', event='') {
        this.methodName = 'createButton';
        let html = '';
        try {
            html += `<input type="button" name="${name}" value="${value}" ${event}>`;
        } catch (err) {
            throw this.errorMessage(this.className, this.methodName, err.message);
        }
        return html;
    }

    // Create radio
    createRadio(name='', value='', selected=false, event="") {
        this.methodName = 'createRadio';
        let html = '';
        try {
            html += `<input type="radio" id="${name}" name="${name}" value="${value}" ${selected} ${event}>`;
        } catch (err) {
            throw this.errorMessage(this.className, this.methodName, err.message);
        }
        return html;
    }

    // Table
    createTable(html='') {
        this.methodName = 'createTable';
        try {
            return '<table>' + html + '</table>';
        } catch (err) {
            throw this.errorMessage(this.className, this.methodName, err.message);
        }
    }

    // Row
    createTableRow(html='') {
        this.methodName = 'createTableRow';
        try {
            return '<tr>' + html + '</tr>';
        } catch (err) {
            throw this.errorMessage(this.className, this.methodName, err.message);
        }
    }

    // Header
    createTableHeader(value='') {
        this.methodName = 'createTableHeader';
        try {
            return '<th>' + value.trim() + '</th>';
        } catch (err) {
            throw this.errorMessage(this.className, this.methodName, err.message);
        }
    }

    // Column
    createTableCol(html='') {
        this.methodName = 'createTableCol';
        try {
            return '<td>' + html + '</td>';
        } catch (err) {
            throw this.errorMessage(this.className, this.methodName, err.message);
        }
    }
// End of class
}