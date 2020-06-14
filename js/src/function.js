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

function go(dest) {

    let table = '';
    let button = '';
    let form = '';

    try {

        // Present the screen
        switch (dest.trim()) {
            case 'table':
                table = new Table(0);
                setDiv('div2', table.createTable());
                break;
            case 'form':
                form = new Form(0);
                setDiv('div2', form.createForm());
                break;
            default:
                setDiv('div2', '');
        }

        // Present screen according to user action
        button = new Button(data);    
        setDiv('div3', button.do());

    } catch (err) {    
        setDiv('div1', '');
        setDiv('div2', err.message);
        setDiv('div3', '');
    }
}