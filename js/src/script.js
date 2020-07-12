function setDiv(div, html) {
    document.getElementById(div).innerHTML = html;
}

function txt(value) {
    return "'" + value + "'";
}

function setId(id) {
    localStorage.id = id;
}

function go(tableId=0, dest=1) {

    // General declaration
    let systemId = 0;
    let userId = 0;
    let languageId = 0;
    let form = "";
    let table = "";

    try {

        // Current session    
        systemId = parseInt(localStorage.systemId);
        userId = parseInt(localStorage.userId);
        languageId = parseInt(localStorage.languageId);     
        
        alert(systemId);

        // Present the screen
        switch (dest) {
            case 1:
                table = new Table(systemId, tableId, userId, languageId);
                setDiv('div2', table.createTable());
                break;
            case 2:
                form = new Form(systemId, tableId, userId, languageId);
                setDiv('div2', form.createForm());
                break;
            default:
                setDiv('div2', '');
        }
    } catch (err) {    
        setDiv('div1', '');
        setDiv('div2', err.message);
        setDiv('div3', '');
    }
}

function login()  {
    try {
        // Clear page body
        setDiv('div2', ``);
        // Create menu    
        let menu = new Menu();
        setDiv('div1', menu.createMenu());
    } catch (err) {
        setDiv('div1', '');
        setDiv('div2', err.message);
        setDiv('div3', '');
    }
}


function session() {
    // Keep credentials
    localStorage.systemId = 1;        // Current system
    localStorage.tableId = "";        // Current table name
    localStorage.userId = 0;          // Logged user
    localStorage.languageId = 1;      // System language
    localStorage.id = 0;            // Selected Id in report    
}









/*
FOR FUTURE USE
let func = [];
var se = document.createElement('script');
se.setAttribute('type', 'text/javascript');
for (let i=0; i<3; i++) {
  se.appendChild(document.createTextNode(func[i]));
}
document.getElementsByTagName('head').item(0).appendChild(se);
*/