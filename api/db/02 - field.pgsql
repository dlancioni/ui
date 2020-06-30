-- -----------------------------------------------------
-- Set default schema
-- -----------------------------------------------------
ALTER ROLE qqbzxiqr IN DATABASE qqbzxiqr SET search_path TO system;

-- -----------------------------------------------------
-- table tb_system
-- -----------------------------------------------------
delete from tb_system;
insert into tb_system (field) values ('{"id":0,"name":"Forms","expire_date":"31/12/2020","price":"100.00"}');

-- -----------------------------------------------------
-- table tb_table
-- -----------------------------------------------------
delete from tb_table;
insert into tb_table (field) values ('{"id":0,"id_system":1,"name":"System","id_type":1,"title":"System","table_name":"tb_system"}');
insert into tb_table (field) values ('{"id":0,"id_system":1,"name":"Menu","id_type":1,"title":"Menu","table_name":"tb_menu"}');
insert into tb_table (field) values ('{"id":0,"id_system":1,"name":"Table","id_type":1,"title":"Table","table_name":"tb_table"}');
insert into tb_table (field) values ('{"id":0,"id_system":1,"name":"Field","id_type":1,"title":"Field","table_name":"tb_field"}');
insert into tb_table (field) values ('{"id":0,"id_system":1,"name":"Domain","id_type":1,"title":"Domain","table_name":"tb_domain"}');
insert into tb_table (field) values ('{"id":0,"id_system":1,"name":"Event","id_type":1,"title":"Event", "table_name":"tb_event"}');
insert into tb_table (field) values ('{"id":0,"id_system":1,"name":"Code","id_type":1,"title":"Code","table_name":"tb_code"}');
insert into tb_table (field) values ('{"id":0,"id_system":1,"name":"Catalog","id_type":1,"title":"Catalog","table_name":"tb_catalog"}');

-- -----------------------------------------------------
-- table tb_field
-- -----------------------------------------------------
delete from tb_field;
-- tb_system
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":1,"label":"Id","name":"id","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":1,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":1,"label":"Expire Date","name":"expire_date","id_type":4,"size":0,"mask":"dd/mm/yyyy","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":1,"label":"Price","name":"price","id_type":2,"size":0,"mask":"1.000,00","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_menu
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":2,"label":"Id","name":"id","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":2,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":2,"label":"Parent","name":"id_parent","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":2,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":2,"label":"Url","name":"url","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_table
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":3,"label":"Id","name":"id","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":3,"label":"System","name":"id_system","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":1,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":3,"label":"Type","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":5,"domain":"tb_table_type"}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":3,"label":"Title","name":"title","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":3,"label":"Table Name","name":"table_name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
-- tb_field
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Id","name":"id","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Table","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":3,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Label","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Type","name":"id_type","id_type":3,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":5,"domain":"tb_id_type"}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Size","name":"size","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Mask","name":"mask","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Mandatory","name":"id_mandatory","id_type":5,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":5,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Unique","name":"id_unique","id_type":5,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":5,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Fk","name":"id_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":3,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":4,"label":"Domain","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_domain
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":5,"label":"Id","name":"id","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":5,"label":"Key","name":"key","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":5,"label":"Value","name":"value","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":5,"label":"Domain","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_event
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":6,"label":"Id","name":"id","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":6,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":6,"label":"Target","name":"id_page","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":5,"domain":"tb_target"}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":6,"label":"Table","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":3,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":6,"label":"Field","name":"id_field","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_fk":4,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":6,"label":"Event","name":"id_event","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":5,"domain":"tb_event"}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":6,"label":"Display Type","name":"id_event_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":5,"domain":"tb_event_type"}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":6,"label":"Display","name":"display","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":6,"label":"Code","name":"code","id_type":3,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_code
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":7,"label":"Id","name":"id","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":7,"label":"Code","name":"code","id_type":3,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
-- tb_catalog
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":8,"label":"Id","name":"id","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":8,"label":"Language","name":"id_language","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":5,"domain":"tb_language"}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":8,"label":"Type","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":5,"domain":"tb_catalog_type"}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":8,"label":"Key","name":"key","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id":0,"id_system":1,"id_table":8,"label":"Value","name":"value","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_fk":0,"domain":""}');
