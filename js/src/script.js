let func = 
[
    `
    function setDiv(div, html) {
        document.getElementById(div).innerHTML = html;
    }
    `,
    `
    function txt(value) {
        return "'" + value + "'";
    }
    `,
    `
    function setId(id) {
        localStorage.id = id;
    }
    `
]
var se = document.createElement('script');
se.setAttribute('type', 'text/javascript');
for (let i=0; i<3; i++) {
  se.appendChild(document.createTextNode(func[i]));
}
document.getElementsByTagName('head').item(0).appendChild(se);

function go(id_table=0, dest=1) {

    let table = '';
    let button = '';
    let form = '';
    let data = '';

    try {

        // Present the screen
        switch (dest) {
            case 1:
                table = new Table(id_table);
                setDiv('div2', table.createTable());
                break;
            case 2:
                form = new Form(id_table);
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

    // Clear page body
    setDiv('div2', ``);

    // Create menu    
    let menu = new Menu();
    setDiv('div1', menu.createMenu());

    // Keep credentials
    localStorage.system = 1;        // Current system
    localStorage.table = 0;         // Current table (transation)
    localStorage.user = 0;          // Logged user
    localStorage.language = 1;      // System language
    localStorage.id = 0;            // Selected Id in report
    localStorage.target = 0;        // 1-Report, 2-Form
}

function filter(tableName, fieldName, fieldValue, fieldType="int", fieldOperator="=", fieldMask="") {
    let output = '';
    output = `{"table":"${tableName}","field":"${fieldName}","type":"${fieldType}","operator":"${fieldOperator}","value":${fieldValue},"mask":"${fieldMask}"}`;
    return output;
}