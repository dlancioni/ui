const { Form } = require("./form.js");

// Test Method
function test_createTextbox() {
    
    let form = new Form('', '');
    if (form.createTextbox("", "id", "") != `<input type="text" id="id" name="id" value="">`) {
        console.log("createTextbox() -> Cannot create a basic input"); return;
    }
    if (form.createTextbox("", "id", "", "Id...") != `<input type="text" id="id" name="id" value="" placeholder="Id...">`) {
        console.log("createTextbox() -> Cannot create a basic text input within placeholder"); return;
    }    
    if (form.createTextbox("", "id", "", "Id...", true) != `<input type="text" id="id" name="id" value="" placeholder="Id..." disabled>`) {
        console.log("createTextbox() -> Cannot create a disabled text input"); return;
    }
    if (form.createTextbox("Id", "id", "", "Id...") != `<label for="id">Id</label><input type="text" id="id" name="id" value="" placeholder="Id...">`) {
        console.log("createTextbox() -> Cannot create a text input within label"); return;
    }    
}

function test_createForm() {

    let struct = '';
    let data = '';
    let value = '';
    let form = '';

    // Common data
    struct = '[{"id":9,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"id","field_label":"Id","field_type":"integer","field_size":0,"field_mask":"","field_fk":0,"id_mandatory":"Y","id_unique":"Y","domain_name":""},{"id":10,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"name","field_label":"Nome","field_type":"string","field_size":50,"field_mask":"","field_fk":0,"id_mandatory":"Y","id_unique":"Y","domain_name":""},{"id":11,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"expire_date","field_label":"Expira em","field_type":"date","field_size":0,"field_mask":"dd/mm/yyyy","field_fk":0,"id_mandatory":"Y","id_unique":"N","domain_name":""},{"id":12,"id_system":1,"id_table":1,"table_name":"tb_system","field_name":"price","field_label":"Preço","field_type":"decimal","field_size":0,"field_mask":"1.000,00","field_fk":0,"id_mandatory":"Y","id_unique":"N","domain_name":""}]';

    // Test an empty form (new)
    data = '[]';
    form = new Form(struct, data);
    value = `<form id="form1"><label for="id">Id</label><input type="text" id="id" name="id" value=""><label for="name">Nome</label><input type="text" id="name" name="name" value=""><label for="expire_date">Expira em</label><input type="text" id="expire_date" name="expire_date" value=""><label for="price">Preço</label><input type="text" id="price" name="price" value=""></form>`
    if (form.createForm() != value) {
        console.log("do() -> Fail to create an empty form"); return;
    }

    // Test filler form (edit)
    data = '[{"id":1,"name":"Forms","price":"100.00","expire_date":"31/12/2020"}]';
    form = new Form(struct, data);
    value = `<form id="form1"><label for="id">Id</label><input type="text" id="id" name="id" value="1"><label for="name">Nome</label><input type="text" id="name" name="name" value="Forms"><label for="expire_date">Expira em</label><input type="text" id="expire_date" name="expire_date" value="31/12/2020"><label for="price">Preço</label><input type="text" id="price" name="price" value="100.00"></form>`
    if (form.createForm() != value) {
        console.log("createForm() -> Fail to create an filled form"); return;
    }    
}

console.log("Testing Form class...")
test_createTextbox();
test_createForm();
console.log("Test done")
