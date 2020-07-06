let func = [
 `
  function setDiv(div, html) {
      document.getElementById(div).innerHTML = html;
  } 
  `
]
var se = document.createElement('script');
se.setAttribute('type', 'text/javascript');
for (let i=0; i<1; i++) {
  se.appendChild(document.createTextNode(func[i]));
}
document.getElementsByTagName('head').item(0).appendChild(se);

function go(id=0, dest="Report") {

    let table = '';
    let button = '';
    let form = '';
    let data = '';

    try {

        // Present the screen
        switch (dest.trim()) {
            case 'Report':
                table = new Table(id);
                setDiv('div2', table.createTable());
                break;
            case 'Form':
                form = new Form(id);
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