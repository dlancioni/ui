let func = [
 `
  function setDiv(div, html) {
      document.getElementById(div).innerHTML = html;
  } 
  `
]

var se = document.createElement('script');
se.setAttribute('type', 'text/javascript');

for (let i=0; i<4; i++) {
  se.appendChild(document.createTextNode(func[i]));
}
document.getElementsByTagName('head').item(0).appendChild(se);

function go(dest) {

  let struct = '{}';
  let data = '{}';
  let html = ''; 

  let table = '';
  let button= '';
  let form= '';

  try {
    // Table structure for tb_system
    let struct = '[{"id":9,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"id","field_label":"Id","field_type":"integer","field_size":0,"field_mask":"","field_fk":0,"id_mandatory":"Y","id_unique":"Y","domain_name":""},{"id":10,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"name","field_label":"Nome","field_type":"string","field_size":50,"field_mask":"","field_fk":0,"id_mandatory":"Y","id_unique":"Y","domain_name":""},{"id":11,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"expire_date","field_label":"Expira em","field_type":"date","field_size":0,"field_mask":"dd/mm/yyyy","field_fk":0,"id_mandatory":"Y","id_unique":"N","domain_name":""},{"id":12,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"price","field_label":"Preço","field_type":"decimal","field_size":0,"field_mask":"1.000,00","field_fk":0,"id_mandatory":"Y","id_unique":"N","domain_name":""}]';
    let data = '[{"id":1,"name":"Forms","price":"100.00","expire_date":"31/12/2020"}]';

    table = new Table(struct, data);
    form = new Form(struct, data);
    button = new Button(data);

    // Present screen
    switch (dest.trim()) {
      case 'table':
        setDiv('div2', table.do());
        break;
      case 'form':
        setDiv('div2', form.createForm());
        break;
      default:
        setDiv('div2', '');
    }
    // Present screen according to user action
    setDiv('div3', button.do());

  } catch (err) {    
    setDiv('div1', '');
    setDiv('div2', err.message);
    setDiv('div3', '');
  }

}