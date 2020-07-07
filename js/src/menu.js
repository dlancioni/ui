class Menu {

    // Constructor
    constructor(id) {
        this.id = id;        
        this.className = 'HTMLElement';
        this.methodName = '';
    }    

    errorMessage(className='', methodName='', message='') {
        let msg = '';
        msg = className + '.' + methodName + ': ' + message;
        return msg;
    }

    // Public methods  
    createMenu() {
        this.methodName = 'createMenu';
        let html = '';
        try {
            html += `<a onclick="go(1)">System</a>` + '&nbsp';
            html += `<a onclick="go(2)">Table</a>` + '&nbsp';
            html += `<a onclick="go(3)">Field</a>` + '&nbsp';
            html += `<a onclick="go(4)">Domain</a>` + '&nbsp';
            html += `<a onclick="go(5)">Event</a>` + '&nbsp';
            html += `<a onclick="go(6)">Code</a>` + '&nbsp';
            html += `<a onclick="go(7, 2)">Login</a>` + '&nbsp';
            return html;  
        } catch (err) {
            throw this.errorMessage(this.className, this.methodName, err.message);
        }
    }
}