-- -----------------------------------------------------
-- Set default schema
-- -----------------------------------------------------
ALTER ROLE qqbzxiqr IN DATABASE qqbzxiqr SET search_path TO system;

drop table if exists tb_system cascade; 
create table if not exists tb_system (id serial, field jsonb);

drop table if exists tb_table cascade;
create table if not exists tb_table (id serial, field jsonb);

drop table if exists tb_field cascade;
create table if not exists tb_field (id serial, field jsonb);

drop table if exists tb_domain cascade;
create table if not exists tb_domain (id serial, field jsonb);

drop table if exists tb_event cascade;
create table if not exists tb_event (id serial, field jsonb);

drop table if exists tb_action cascade;
create table if not exists tb_action (id serial, field jsonb);

drop table if exists tb_code cascade;
create table if not exists tb_code (id serial, field jsonb);

drop table if exists tb_message cascade;
create table if not exists tb_message (id serial, field jsonb);

drop table if exists tb_group cascade;
create table if not exists tb_group (id serial, field jsonb);

-- -----------------------------------------------------
-- table tb_system
-- -----------------------------------------------------
delete from tb_system;
insert into tb_system (field) values ('{"name":"Forms","expire_date":"31/12/2020","price":"100.00"}');

-- -----------------------------------------------------
-- table tb_table
-- -----------------------------------------------------
delete from tb_table;
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"tb_system","id_type":1,"title":"Sistemas","id_parent":10}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"tb_table","id_type":1,"title":"Tabelas","id_parent":10}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"tb_field","id_type":1,"title":"Campos","id_parent":10}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"tb_domain","id_type":1,"title":"Domínios","id_parent":10}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"tb_event","id_type":1,"title":"Eventos","id_parent":10}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"tb_action","id_type":1,"title":"Ações","id_parent":10}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"tb_code","id_type":1,"title":"Programação","id_parent":10}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"tb_message","id_type":1,"title":"Mensagens","id_parent":10}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"tb_group","id_type":1,"title":"Grupos","id_parent":10}');

insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"-","id_type":3,"title":"Administração","id_parent":0}');


-- -----------------------------------------------------
-- table tb_field
-- -----------------------------------------------------
delete from tb_field;
-- tb_system
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":1,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":1,"label":"Expira em","name":"expire_date","id_type":4,"size":0,"mask":"dd/mm/yyyy","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":1,"label":"Preço","name":"price","id_type":2,"size":0,"mask":"1.000,00","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_table
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Sistema","name":"id_system","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":1,"id_field_fk":1,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Tipo","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_table_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Titulo","name":"title","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Parente","name":"id_parent","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":2,"id_field_fk":7,"domain":""}');
-- tb_field
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Tabela","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":7,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Rótulo","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Tipo","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_field_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Tamanho","name":"size","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Máscara","name":"mask","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Obrigatório","name":"id_mandatory","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Único","name":"id_unique","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Tabela Fk","name":"id_table_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":2,"id_field_fk":5,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Campo Fk","name":"id_field_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":3,"id_field_fk":11,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Domínio","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_domain
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":4,"label":"Chave","name":"key","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":4,"label":"Valor","name":"value","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":4,"label":"Domínio","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_event
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Tela","name":"id_target","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":4,"id_field_fk":20,"domain":"tb_target"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Tabela","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":7,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Campo","name":"id_field","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":1,"id_table_fk":3,"id_field_fk":11,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Ação","name":"id_action","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":1,"id_table_fk":6,"id_field_fk":29,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Evento","name":"id_event","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":4,"id_field_fk":20,"domain":"tb_event"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Código","name":"code","id_type":6,"size":10000,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_action
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":6,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":6,"label":"Rótulo","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_code
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":7,"label":"Comentário","name":"comment","id_type":3,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":7,"label":"Código","name":"code","id_type":6,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_mensagens
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":8,"label":"Tipo","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":4,"id_field_fk":20,"domain":"tb_message_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":8,"label":"Código","name":"code","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":8,"label":"Descrição","name":"description","id_type":3,"size":500,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_group
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":9,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');


-- -----------------------------------------------------
-- table tb_domain
-- -----------------------------------------------------
delete from tb_domain;
-- tb_table_type
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"1","value":"Sistema","domain":"tb_table_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"2","value":"Usuário","domain":"tb_table_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"3","value":"Menu","domain":"tb_table_type"}');
-- tb_bool
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"1","value":"Sim","domain":"tb_bool"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"2","value":"Não","domain":"tb_bool"}');
-- tb_field_type
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":1,"value":"Inteiro","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":2,"value":"Decimal","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":3,"value":"Texto","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":4,"value":"Data","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":5,"value":"Hora","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":6,"value":"Area","domain":"tb_field_type"}');
-- tb_event
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":1,"value":"onLoad","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":2,"value":"onClick","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":3,"value":"onChange","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":4,"value":"onFocus","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":5,"value":"onBlur","domain":"tb_event"}');
-- tb_target
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":1,"value":"Tabela","domain":"tb_target"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":2,"value":"Formulário","domain":"tb_target"}');
-- tb_message_type
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":1,"value":"Alerta","domain":"tb_message_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":2,"value":"Rótulo","domain":"tb_message_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":3,"value":"Erro","domain":"tb_message_type"}');

-- -----------------------------------------------------
-- table tb_action
-- -----------------------------------------------------
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Novo","label":"Novo"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Editar","label":"Editar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Apagar","label":"Apagar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Confirmar","label":"Confirmar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Filtrar","label":"Filtrar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Limpar","label":"Limpar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Voltar","label":"Voltar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Testar","label":"Testar"}');

-- -----------------------------------------------------
-- table tb_code
-- -----------------------------------------------------
insert into tb_code (field) values ('{"id_system":1,"id_group":1,"comment":"Evita nomes inválidos para tabela de banco de dados", "code": "function validateTableName(value) {\r\n\r\n    // Define patter\r\n    let output = \"\";\r\n    let pattern = /[A-Za-z0-9_]/g; \r\n\r\n    // If has value\r\n    if (value.trim() != \"\") {\r\n        output = value.match(pattern).toString().replace(/,/g, '''');\r\n    }\r\n\r\n    // Just return\r\n    return output.trim();\r\n}"}');

-- -----------------------------------------------------
-- table tb_message
-- -----------------------------------------------------
insert into tb_message (field) values ('{"id_system":1,"id_group":1,"id_type":1, "code":"A1", "description":"Campo % é obrigatório"}');
insert into tb_message (field) values ('{"id_system":1,"id_group":1,"id_type":1, "code":"A2", "description":"Data inválida informada no campo %"}');
insert into tb_message (field) values ('{"id_system":1,"id_group":1,"id_type":1, "code":"A3", "description":"Numero inválido informada no campo %"}');
insert into tb_message (field) values ('{"id_system":1,"id_group":1,"id_type":1, "code":"A4", "description":"Os valores para os campos % ja existem na tabela e não podem se repetir"}');
insert into tb_message (field) values ('{"id_system":1,"id_group":1,"id_type":1, "code":"A5", "description":"Nenhuma mudança identifica no registro, alteração não realizada"}');


-- -----------------------------------------------------
-- table tb_message
-- -----------------------------------------------------
insert into tb_group (field) values ('{"id_system":1,"id_group":1,"name":"Sistema"}');
insert into tb_group (field) values ('{"id_system":1,"id_group":2,"name":"Público"}');


-- ---------------------------------------------------------------------------------
-- table tb_event (buttons are inherited from tb_system to all other system tables)
-- ---------------------------------------------------------------------------------
-- tb_system
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');

-- Custon events
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":3,"id_action":0,"id_event":3,"code":"this.value = formatValue(this.value)"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":5,"label":"","id_event":3,"code":"this.value = validateTableName(this.value)"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":17,"id_action":0,"id_event":3,"code":"cascade(this.value, ''id_table_fk'', ''id_field_fk'')"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":24,"id_action":0,"id_event":3,"code":"cascade(this.value, ''id_table'', ''id_field'')"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_action":8,"id_event":2,"code":"eval(field(''code'').value);"}');
