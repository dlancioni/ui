-- -----------------------------------------------------
-- Set default schema
-- -----------------------------------------------------
ALTER ROLE qqbzxiqr IN DATABASE qqbzxiqr SET search_path TO system;

-- -----------------------------------------------------
-- table tb_system
-- -----------------------------------------------------
delete from tb_system;
insert into tb_system (field) values ('{"name":"Forms","expire_date":"31/12/2020","price":"100.00"}');

-- -----------------------------------------------------
-- table tb_table
-- -----------------------------------------------------
delete from tb_table;
insert into tb_table (field) values ('{"id_system":1,"name":"System","id_type":1,"title":"System","table_name":"tb_system"}');
insert into tb_table (field) values ('{"id_system":1,"name":"Table","id_type":1,"title":"Table","table_name":"tb_table"}');
insert into tb_table (field) values ('{"id_system":1,"name":"Field","id_type":1,"title":"Field","table_name":"tb_field"}');
insert into tb_table (field) values ('{"id_system":1,"name":"Domain","id_type":1,"title":"Domain","table_name":"tb_domain"}');
insert into tb_table (field) values ('{"id_system":1,"name":"Event","id_type":1,"title":"Event", "table_name":"tb_event"}');
insert into tb_table (field) values ('{"id_system":1,"name":"Code","id_type":1,"title":"Code","table_name":"tb_code"}');

-- -----------------------------------------------------
-- table tb_field
-- -----------------------------------------------------
delete from tb_field;
-- tb_system
insert into tb_field (field) values ('{"id_system":1,"id_table":1,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":1,"label":"Expire Date","name":"expire_date","id_type":4,"size":0,"mask":"dd/mm/yyyy","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":1,"label":"Price","name":"price","id_type":2,"size":0,"mask":"1.000,00","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_table
insert into tb_field (field) values ('{"id_system":1,"id_table":2,"label":"System","name":"id_system","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":1,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":2,"label":"Type","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":4,"domain":"tb_table_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":2,"label":"Title","name":"title","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":2,"label":"Table Name","name":"table_name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
-- tb_field
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Table","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":2,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Label","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Type","name":"id_type","id_type":3,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":4,"domain":"tb_field_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Size","name":"size","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Mask","name":"mask","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Mandatory","name":"id_mandatory","id_type":5,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":4,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Unique","name":"id_unique","id_type":5,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":4,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Fk","name":"id_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":2,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Domain","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_domain
insert into tb_field (field) values ('{"id_system":1,"id_table":4,"label":"Key","name":"key","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":4,"label":"Value","name":"value","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":4,"label":"Domain","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_event
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Target","name":"id_page","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":4,"domain":"tb_target"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Table","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":3,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Field","name":"id_field","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":4,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Label","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Event","name":"id_event","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":4,"domain":"tb_event"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Code","name":"code","id_type":3,"size":10000,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_code
insert into tb_field (field) values ('{"id_system":1,"id_table":6,"label":"Code","name":"code","id_type":3,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');

-- -----------------------------------------------------
-- table tb_domain
-- -----------------------------------------------------
delete from tb_domain;
-- tb_table_type
insert into tb_domain (field) values ('{"id_system":1,"key":"1","value":"Sistema","domain":"tb_table_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":"2","value":"Usuário","domain":"tb_table_type"}');
-- tb_bool
insert into tb_domain (field) values ('{"id_system":1,"key":"1","value":"Sim","domain":"tb_bool"}');
insert into tb_domain (field) values ('{"id_system":1,"key":"2","value":"Não","domain":"tb_bool"}');
-- tb_field_type
insert into tb_domain (field) values ('{"id_system":1,"key":1,"value":"Inteiro","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":2,"value":"Decimal","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":3,"value":"Texto","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":4,"value":"Data","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"key":5,"value":"Booleano","domain":"tb_field_type"}');
-- tb_event
insert into tb_domain (field) values ('{"id_system":1,"key":"onLoad","value":"Carregar","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":"onClick","value":"Clicar","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":"onFocus","value":"Focar","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":"onBlur","value":"Desfocar","domain":"tb_event"}');