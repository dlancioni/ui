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

    // Execute URL and return data
    async function httpQuery(param) {
        var data = new URLSearchParams();    
        data.append('param', param);
        let response = await fetch('api/src/query.php', {method: 'post', body: data})
        if (response.ok) {
            let json = await response.text();
            return json;
        } else {
            alert("HTTP-Error: " + response.status);
        }
    }

async function go(dest) {

    let struct = '{}';
    let data = '{}';
    let html = ''; 

    let table = '';
    let button= '';
    let form= '';

    try {

        // Get data
        struct = await httpQuery('struct');
        data = await httpQuery('data');

        // Present screen
        switch (dest.trim()) {
            case 'table':
                table = new Table(struct, data);
                setDiv('div2', table.createTable());
                break;
            case 'form':
                form = new Form(struct, data);                
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