-- -----------------------------------------------------
-- Set default schema
-- -----------------------------------------------------
ALTER ROLE qqbzxiqr IN DATABASE qqbzxiqr SET search_path TO system;

-- -----------------------------------------------------
-- CREATE TABLES
-- -----------------------------------------------------
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
drop table if exists tb_group cascade;      
create table if not exists tb_group (id serial, field jsonb);
drop table if exists tb_view cascade;       
create table if not exists tb_view (id serial, field jsonb);
drop table if exists tb_view_field cascade;       
create table if not exists tb_view_field (id serial, field jsonb);
drop table if exists tb_profile cascade;       
create table if not exists tb_profile (id serial, field jsonb);
drop table if exists tb_profile_table cascade;       
create table if not exists tb_profile_table (id serial, field jsonb);
drop table if exists tb_table_function cascade;       
create table if not exists tb_table_function (id serial, field jsonb);
drop table if exists tb_user cascade;       
create table if not exists tb_user (id serial, field jsonb);
drop table if exists tb_user_profile cascade;
create table if not exists tb_user_profile (id serial, field jsonb);
-- -----------------------------------------------------
-- 1 TB_SYSTEM
-- -----------------------------------------------------
insert into tb_system (field) values ('{"name":"Forms","expire_date":"31/12/2020","price":"100.00"}');

-- -----------------------------------------------------
-- 2 TB_TABLE
-- -----------------------------------------------------
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Sistemas","id_type":1,"table_name":"tb_system","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Transações","id_type":1,"table_name":"tb_table","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Campos","id_type":1,"table_name":"tb_field","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Domínios","id_type":1,"table_name":"tb_domain","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Eventos","id_type":1,"table_name":"tb_event","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Ações","id_type":1,"table_name":"tb_action","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Programação","id_type":1,"table_name":"tb_code","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Grupos","id_type":1,"table_name":"tb_group","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Visão","id_type":1,"table_name":"tb_view","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Visão x Campos","id_type":1,"table_name":"tb_view_field","id_parent":16}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Perfil","id_type":1,"table_name":"tb_profile","id_parent":17}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Perfil x Transação","id_type":1,"table_name":"tb_profile_table","id_parent":17}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Transação x Function","id_type":1,"table_name":"tb_table_function","id_parent":17}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Usuários","id_type":1,"table_name":"tb_user","id_parent":17}');
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Usuários x Perfil","id_type":1,"table_name":"tb_user_profile","id_parent":17}');

insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Administração","id_type":3,"table_name":"","id_parent":0}');      -- MENU
insert into tb_table (field) values ('{"id_system":1,"id_group":1,"name":"Controle de Acesso","id_type":3,"table_name":"","id_parent":0}'); -- MENU

-- -----------------------------------------------------
-- 3 TB_FIELD
-- -----------------------------------------------------
-- tb_system
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":1,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":1,"label":"Expira em","name":"expire_date","id_type":4,"size":0,"mask":"dd/mm/yyyy","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":1,"label":"Preço","name":"price","id_type":2,"size":0,"mask":"1.000,00","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_table
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Sistema","name":"id_system","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":1,"id_field_fk":1,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Tipo","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_table_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Tabela","name":"table_name","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":2,"label":"Parente","name":"id_parent","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":2,"id_field_fk":6,"domain":""}');
-- tb_field
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Tabela","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":6,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Rótulo","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Tipo","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_field_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Tamanho","name":"size","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Máscara","name":"mask","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Obrigatório","name":"id_mandatory","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Único","name":"id_unique","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Tabela Fk","name":"id_table_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":2,"id_field_fk":6,"domain":""}'); -- tb_transaction.name
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Campo Fk","name":"id_field_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":3,"id_field_fk":10,"domain":""}'); -- tb_field.label
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":3,"label":"Domínio","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_domain
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":4,"label":"Chave","name":"key","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":4,"label":"Valor","name":"value","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":4,"label":"Domínio","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_event
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Tela","name":"id_target","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":4,"id_field_fk":20,"domain":"tb_target"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Tabela","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":6,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Campo","name":"id_field","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":1,"id_table_fk":3,"id_field_fk":10,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Ação","name":"id_action","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":1,"id_table_fk":6,"id_field_fk":29,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Evento","name":"id_event","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":4,"id_field_fk":20,"domain":"tb_event"}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":5,"label":"Código","name":"code","id_type":6,"size":10000,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_action
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":6,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_code
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":7,"label":"Comentário","name":"comment","id_type":3,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":7,"label":"Código","name":"code","id_type":6,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_group
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":8,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_view
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":9,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":9,"label":"SQL","name":"sql","id_type":6,"size":5000,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_view_field
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":10,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_profile
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":11,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_profile_table
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":12,"label":"Perfil","name":"id_profile","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":11,"id_field_fk":36,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":12,"label":"Transação","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":6,"domain":""}');
-- tb_table_function
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":13,"label":"Transação","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":6,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":13,"label":"Função","name":"id_function","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":6,"id_field_fk":29,"domain":""}');
-- tb_user
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":14,"label":"Nome","name":"fullname","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":14,"label":"Login","name":"login","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":14,"label":"Senha","name":"password","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_user_profile
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":15,"label":"Usuários","name":"id_user","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":14,"id_field_fk":41,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_group":1,"id_table":15,"label":"Perfil","name":"id_profile","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":11,"id_field_fk":36,"domain":""}');

-- -----------------------------------------------------
-- 4 TB_DOMAIN
-- -----------------------------------------------------
-- tb_table_type
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"1","value":"Formulário","domain":"tb_table_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"2","value":"Relatório","domain":"tb_table_type"}');
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
-- tb_message
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A1","value":"Campo % é obrigatório","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A2","value":"Data inválida informada no campo %","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A3","value":"Numero inválido informada no campo %","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A4","value":"Os valores para os campos % ja existem na tabela e não podem se repetir","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A5","value":"Nenhuma mudança identifica no registro, alteração não realizada","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A6","value":"Registro incluído com sucesso","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A7","value":"Registro alterado com sucesso","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A8","value":"Registro excluído com sucesso","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A9","value":"Campo Tabela FK foi selecionado, entao Campo FK é obrigatório","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A10","value":"Transação selecionada é do tipo menu, não é permitido adicionar campos","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A11","value":"Registro pertence ao grupo Sistema, não pode ser modificado ou excluído","domain":"tb_message"}');
-- tb_cascade
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"tb_field.id_table_fk","value":"id_field_fk; tb_field; id; label","domain":"tb_cascade"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"tb_event.id_table","value":"id_field; tb_field; id; label","domain":"tb_cascade"}');

-- -----------------------------------------------------
-- 6 TB_ACTION
-- -----------------------------------------------------
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Novo"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Editar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Apagar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Confirmar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Filtrar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Limpar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Voltar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Testar"}');

-- -----------------------------------------------------
-- 7 TB_CODE
-- -----------------------------------------------------
insert into tb_code (field) values ('{"id_system": 1, "id_group": 1, "comment": "Obtem o valor numérico de um campo", "id": 1, "code": "function valor(campo) {\r\n\r\n    value = field(campo).value;\r\n\r\n    if (value.trim() == \"\") {\r\n        value = \"0\";\r\n    }\r\n\r\n    if (!isNumeric(value)) {\r\n        value = \"0\";\r\n    }\r\n\r\n    value = value.split(\".\").join(\"\");\r\n    value = value.split(\",\").join(\".\");\r\n    value = parseFloat(value);\r\n\r\n    return value;\r\n}"}');
insert into tb_code (field) values ('{"id_system": 1, "id_group": 1, "comment": "Exemplo de query em banco de dados", "id": 2, "code": "let rs = query(\"select 1*2 as total\");\r\nalert(rs[0].total);"}');

-- -----------------------------------------------------
-- 8 TB_GROUP
-- -----------------------------------------------------
insert into tb_group (field) values ('{"id_system":1,"id_group":1,"name":"Sistema"}');
insert into tb_group (field) values ('{"id_system":1,"id_group":1,"name":"Público"}');

-- ---------------------------------------------------------------------------------
-- 5 TB_USER
-- ---------------------------------------------------------------------------------
insert into tb_user (field) values ('{"id_system":1,"id_group":1,"fullname":"Administrador","login":"admin","password":"123"}');
insert into tb_user (field) values ('{"id_system":1,"id_group":1,"fullname":"João","login":"joao","password":"123"}');
insert into tb_user (field) values ('{"id_system":1,"id_group":1,"fullname":"Maria","login":"maria","password":"123"}');

-- ---------------------------------------------------------------------------------
-- 5 TB_PROFILE
-- ---------------------------------------------------------------------------------
insert into tb_profile (field) values ('{"id_system":1,"id_group":1,"name":"Administrador"}');
insert into tb_profile (field) values ('{"id_system":1,"id_group":1,"name":"Usuário"}');

-- ---------------------------------------------------------------------------------
-- 5 TB_PROFILE_TRANSACTION
-- ---------------------------------------------------------------------------------
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":1}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":2}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":3}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":4}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":5}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":6}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":7}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":8}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":9}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":10}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":11}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":12}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":13}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":14}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":15}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":16}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":17}');


-- ---------------------------------------------------------------------------------
-- 5 TB_USER_PROFILE
-- ---------------------------------------------------------------------------------
insert into tb_user_profile (field) values ('{"id_system":1,"id_user":1,"id_profile":1}');
insert into tb_user_profile (field) values ('{"id_system":1,"id_user":2,"id_profile":2}');
insert into tb_user_profile (field) values ('{"id_system":1,"id_user":3,"id_profile":2}');

-- ---------------------------------------------------------------------------------
-- 5 TB_EVENT
-- ---------------------------------------------------------------------------------
-- tb_system
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":3,"id_action":0,"id_event":3,"code":"this.value = formatValue(this.value)"}');
-- tb_table
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":2,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":2,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":2,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":2,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":5,"label":"","id_event":3,"code":"this.value = validateTableName(this.value)"}');
-- tb_field
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":3,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":3,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":3,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":3,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":17,"id_action":0,"id_event":3,"code":"cascade(''id_field_fk'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'')"}');
-- tb_domain
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":4,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":4,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":4,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":4,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":4,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":4,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":4,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_event
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":5,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":5,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":5,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":5,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":24,"id_action":0,"id_event":3,"code":"cascade(''id_field'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'')"}');
-- tb_action
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":6,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":6,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":6,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":6,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":6,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":6,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":6,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_code
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":7,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":7,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":7,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":7,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_action":8,"id_event":2,"code":"eval(field(''code'').value);"}');
-- tb_group
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":8,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":8,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":8,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":8,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":8,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":8,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":8,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_view
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":9,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":9,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":9,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":9,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":9,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":9,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":9,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_view_field
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":10,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":10,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":10,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":10,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":10,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":10,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":10,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_profile
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":11,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":11,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":11,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":11,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":11,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":11,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":11,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_profile_table
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":12,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":12,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":12,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":12,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":12,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":12,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":12,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_table_function
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":13,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":13,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":13,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":13,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":13,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":13,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":13,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_user
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":14,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":14,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":14,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":14,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":14,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":14,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":14,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_user_profile
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":15,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":15,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":15,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":15,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":15,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":15,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":15,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');