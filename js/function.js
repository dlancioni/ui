let func = [
  "function hi1() {alert(1);}",
  "function calc(a,b) {alert(a+b);}",
  "document.getElementById('div1').innerText = 'maria'",
  `
  function go() {
    let struct = '{}';
    let data = '{}';
    let html = '';
    
    // Table structure for tb_system
    struct = '[{"id":9,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"id","field_label":"Id","field_type":"integer","field_size":0,"field_mask":"","field_fk":0,"id_mandatory":"Y","id_unique":"Y","domain_name":""},{"id":10,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"name","field_label":"Nome","field_type":"string","field_size":50,"field_mask":"","field_fk":0,"id_mandatory":"Y","id_unique":"Y","domain_name":""},{"id":11,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"expire_date","field_label":"Expira em","field_type":"date","field_size":0,"field_mask":"dd/mm/yyyy","field_fk":0,"id_mandatory":"Y","id_unique":"N","domain_name":""},{"id":12,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"price","field_label":"Preço","field_type":"decimal","field_size":0,"field_mask":"1.000,00","field_fk":0,"id_mandatory":"Y","id_unique":"N","domain_name":""}]';
    data = '[{"id":1,"name":"Forms","price":"100.00","expire_date":"31/12/2020"}]';
    let table = new Table(struct, data);
   
    html = table.do();
    
    document.getElementById("divpage").innerHTML = html;
  }
  `  
]

var se = document.createElement('script');
se.setAttribute('type', 'text/javascript');

for (let i=0; i<4; i++) {
  se.appendChild(document.createTextNode(func[i]));
}
document.getElementsByTagName('head').item(0).appendChild(se);

