-- -----------------------------------------------------
-- Set default schema
-- -----------------------------------------------------
ALTER ROLE qqbzxiqr IN DATABASE qqbzxiqr SET search_path TO system;

-- -----------------------------------------------------
-- table tb_system
-- -----------------------------------------------------
drop table if exists tb_system cascade;
create table if not exists tb_system (id serial, field jsonb);
-- -----------------------------------------------------
-- table tb_table
-- -----------------------------------------------------
drop table if exists tb_table cascade;
create table if not exists tb_table (id serial, field jsonb);
-- -----------------------------------------------------
-- table tb_field

-- -----------------------------------------------------
drop table if exists tb_field cascade;
create table if not exists tb_field (id serial, field jsonb);
-- -----------------------------------------------------
-- table tb_domain
-- -----------------------------------------------------
drop table if exists tb_domain cascade;
create table if not exists tb_domain (id serial, field jsonb);
-- -----------------------------------------------------
-- table tb_event
-- -----------------------------------------------------
drop table if exists tb_event cascade;
create table if not exists tb_event (id serial, field jsonb);
-- -----------------------------------------------------
-- table tb_action
-- -----------------------------------------------------
drop table if exists tb_action cascade;
create table if not exists tb_action (id serial, field jsonb);
-- -----------------------------------------------------
-- table tb_code
-- -----------------------------------------------------
drop table if exists tb_code cascade;
create table if not exists tb_code (id serial, field jsonb);
-- -----------------------------------------------------
-- table tb_login
-- -----------------------------------------------------
drop table if exists tb_login cascade;
create table if not exists tb_login (id serial, field jsonb);

-- -----------------------------------------------------
-- table tb_system
-- -----------------------------------------------------
delete from tb_system;
insert into tb_system (field) values ('{"name":"Forms","expire_date":"31/12/2020","price":"100.00"}');

-- -----------------------------------------------------
-- table tb_table
-- -----------------------------------------------------
delete from tb_table;
insert into tb_table (field) values ('{"id_system":1,"name":"tb_system","id_type":1,"title":"System"}');
insert into tb_table (field) values ('{"id_system":1,"name":"tb_table","id_type":1,"title":"Table"}');
insert into tb_table (field) values ('{"id_system":1,"name":"tb_field","id_type":1,"title":"Field"}');
insert into tb_table (field) values ('{"id_system":1,"name":"tb_domain","id_type":1,"title":"Domain"}');
insert into tb_table (field) values ('{"id_system":1,"name":"tb_event","id_type":1,"title":"Event"}');
insert into tb_table (field) values ('{"id_system":1,"name":"tb_action","id_type":1,"title":"Action"}');
insert into tb_table (field) values ('{"id_system":1,"name":"tb_code","id_type":1,"title":"Code"}');

-- -----------------------------------------------------
-- table tb_field
-- -----------------------------------------------------
delete from tb_field;
-- tb_system
insert into tb_field (field) values ('{"id_system":1,"id_table":1,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":1,"label":"Expire Date","name":"expire_date","id_type":4,"size":0,"mask":"dd/mm/yyyy","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":1,"label":"Price","name":"price","id_type":2,"size":0,"mask":"1.000,00","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_table
insert into tb_field (field) values ('{"id_system":1,"id_table":2,"label":"System","name":"id_system","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":1,"id_field_fk":1,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":2,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":2,"label":"Type","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_table_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":2,"label":"Title","name":"title","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_field
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Table","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":2,"id_field_fk":7,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Label","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Type","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_field_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Size","name":"size","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Mask","name":"mask","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Mandatory","name":"id_mandatory","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Unique","name":"id_unique","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Table Fk","name":"id_table_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":2,"id_field_fk":5,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Field Fk","name":"id_field_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":3,"id_field_fk":10,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Domain","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_domain
insert into tb_field (field) values ('{"id_system":1,"id_table":4,"label":"Key","name":"key","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":4,"label":"Value","name":"value","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":4,"label":"Domain","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_event
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Target","name":"id_target","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_target"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Table","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":2,"id_field_fk":7,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Field","name":"id_field","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":3,"id_field_fk":9,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Action","name":"id_action","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":6,"id_field_fk":29,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Event","name":"id_event","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_event"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Code","name":"code","id_type":6,"size":10000,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_action
insert into tb_field (field) values ('{"id_system":1,"id_table":6,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":6,"label":"Label","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');

-- tb_code
insert into tb_field (field) values ('{"id_system":1,"id_table":7,"label":"Code","name":"code","id_type":6,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');


-- -----------------------------------------------------
-- table tb_domain
-- -----------------------------------------------------
delete from tb_domain;
-- tb_table_type
insert into tb_domain (field) values ('{"id_system":1,"key":"1","value":"System","domain":"tb_table_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":"2","value":"User","domain":"tb_table_type"}');
-- tb_bool
insert into tb_domain (field) values ('{"id_system":1,"key":"1","value":"Yes","domain":"tb_bool"}');
insert into tb_domain (field) values ('{"id_system":1,"key":"2","value":"No","domain":"tb_bool"}');
-- tb_field_type
insert into tb_domain (field) values ('{"id_system":1,"key":1,"value":"Integer","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":2,"value":"Decimal","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":3,"value":"Text","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":4,"value":"Date","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":5,"value":"Time","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":6,"value":"TextArea","domain":"tb_field_type"}');
-- tb_event
insert into tb_domain (field) values ('{"id_system":1,"key":1,"value":"onload","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":2,"value":"onClick","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":3,"value":"onChange","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":4,"value":"onFocus","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":5,"value":"onBlur","domain":"tb_event"}');
-- tb_target
insert into tb_domain (field) values ('{"id_system":1,"key":1,"value":"Table","domain":"tb_target"}');
insert into tb_domain (field) values ('{"id_system":1,"key":2,"value":"Form","domain":"tb_target"}');

-- -----------------------------------------------------
-- table tb_event
-- -----------------------------------------------------
-- tb_system
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":1,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":1,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":1,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":1,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":1,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":1,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":1,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":1,"id_field":3,"label":"","id_event":3,"code":"this.value = formatValue(this.value)"}');

-- tb_table
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":2,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":2,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":2,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":2,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":2,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":2,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":2,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":2,"id_field":5,"label":"","id_event":3,"code":"this.value = validateTableName(this.value)"}');

-- tb_field
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":3,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":3,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":3,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":3,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":3,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":3,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":3,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":3,"id_field":16,"id_action":0,"id_event":3,"code":"cascade(this.value, ''id_table_fk'', ''id_field_fk'')"}');

-- tb_domain
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":4,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":4,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":4,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":4,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":4,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":4,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":4,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');

-- tb_event
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":5,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":5,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":5,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":5,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":5,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":5,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":5,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":5,"id_field":23,"id_action":0,"id_event":3,"code":"cascade(this.value, ''id_table'', ''id_field'')"}');

-- tb_action
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":6,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":6,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":6,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":6,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":6,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":6,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":6,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');

-- tb_code
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":7,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":7,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":7,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":7,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":1,"id_table":7,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":7,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":7,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_target":2,"id_table":7,"id_field":0,"id_action":8,"id_event":2,"code":"eval(field(''code'').value);"}');

-- -----------------------------------------------------
-- table tb_action
-- -----------------------------------------------------
insert into tb_action (field) values ('{"id_system":1,"name":"New","label":"New"}');
insert into tb_action (field) values ('{"id_system":1,"name":"Edit","label":"Edit"}');
insert into tb_action (field) values ('{"id_system":1,"name":"Delete","label":"Delete"}');
insert into tb_action (field) values ('{"id_system":1,"name":"Confirm","label":"Confirm"}');
insert into tb_action (field) values ('{"id_system":1,"name":"Filter","label":"Filter"}');
insert into tb_action (field) values ('{"id_system":1,"name":"Clear","label":"Clear"}');
insert into tb_action (field) values ('{"id_system":1,"name":"Back","label":"Back"}');
insert into tb_action (field) values ('{"id_system":1,"name":"Test","label":"Test"}');

-- -----------------------------------------------------
-- table tb_code
-- -----------------------------------------------------
insert into tb_code (field) values ('{"id_system":1,"code":"function test() {alert(''Hello World'');}"}');
insert into tb_code (field) values ('{"id_system":1,"code": "function validateTableName(value) {\r\n\r\n    // Define patter\r\n    let output = \"\";\r\n    let pattern = /[A-Za-z0-9_]/g; \r\n\r\n    // If has value\r\n    if (value.trim() != \"\") {\r\n        output = value.match(pattern).toString().replace(/,/g, '''');\r\n    }\r\n\r\n    // Just return\r\n    return output.trim();\r\n}"}');
