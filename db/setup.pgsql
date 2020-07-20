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
insert into tb_table (field) values ('{"id_system":1,"name":"tb_code","id_type":1,"title":"Code"}');
insert into tb_table (field) values ('{"id_system":1,"name":"tb_login","id_type":1,"title":"Login"}');

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
insert into tb_field (field) values ('{"id_system":1,"id_table":2,"label":"Title","name":"title","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_field
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Table","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":2,"id_field_fk":5,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Label","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Type","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_field_type"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Size","name":"size","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Mask","name":"mask","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Mandatory","name":"id_mandatory","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Unique","name":"id_unique","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Table Fk","name":"id_table_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":2,"id_field_fk":5,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Field Fk","name":"id_field_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":3,"id_field_fk":10,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":3,"label":"Domain","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_domain
insert into tb_field (field) values ('{"id_system":1,"id_table":4,"label":"Key","name":"key","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":4,"label":"Value","name":"value","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":4,"label":"Domain","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_event
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Name","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Target","name":"id_target","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_target"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Table","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":2,"id_field_fk":5,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Field","name":"id_field","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":3,"id_field_fk":3,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Label","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Event","name":"id_event","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_event"}');
insert into tb_field (field) values ('{"id_system":1,"id_table":5,"label":"Code","name":"code","id_type":3,"size":10000,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- tb_code
insert into tb_field (field) values ('{"id_system":1,"id_table":6,"label":"Code","name":"code","id_type":3,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
-- login
insert into tb_field (field) values ('{"id_system":1,"id_table":7,"label":"Usuario","name":"username","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
insert into tb_field (field) values ('{"id_system":1,"id_table":7,"label":"Senha","name":"password","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');

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
-- tb_event
insert into tb_domain (field) values ('{"id_system":1,"key":1,"value":"onload","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":2,"value":"onClick","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":3,"value":"onFocus","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"key":4,"value":"onBlur","domain":"tb_event"}');
-- tb_target
insert into tb_domain (field) values ('{"id_system":1,"key":1,"value":"Tabela","domain":"tb_target"}');
insert into tb_domain (field) values ('{"id_system":1,"key":2,"value":"Formulário","domain":"tb_target"}');

-- -----------------------------------------------------
-- table tb_event
-- -----------------------------------------------------
-- tb_system
insert into tb_event (field) values ('{"id_system":1,"name":"new","id_target":1,"id_table":1,"id_field":0,"label":"New","id_event":2,"code":"go(1,2,''new'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"edit","id_target":1,"id_table":1,"id_field":0,"label":"Edit","id_event":2,"code":"go(1,2,''edit'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"delete","id_target":1,"id_table":1,"id_field":0,"label":"Delete","id_event":2,"code":"go(1,2,''delete'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"save","id_target":2,"id_table":1,"id_field":0,"label":"Confirm","id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"filter","id_target":1,"id_table":1,"id_field":0,"label":"Filter","id_event":2,"code":"go(1,2,''filter'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"clear","id_target":2,"id_table":1,"id_field":0,"label":"Clear","id_event":2,"code":"clear()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"back","id_target":2,"id_table":1,"id_field":0,"label":"Back","id_event":2,"code":"go(1,1,''back'')"}');

-- tb_table
insert into tb_event (field) values ('{"id_system":1,"name":"new","id_target":1,"id_table":2,"id_field":0,"label":"New","id_event":2,"code":"go(2,2,''new'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"edit","id_target":1,"id_table":2,"id_field":0,"label":"Edit","id_event":2,"code":"go(2,2,''edit'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"delete","id_target":1,"id_table":2,"id_field":0,"label":"Delete","id_event":2,"code":"go(2,2,''delete'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"save","id_target":2,"id_table":2,"id_field":0,"label":"Confirm","id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"filter","id_target":1,"id_table":2,"id_field":0,"label":"Filter","id_event":2,"code":"go(2,2,''filter'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"clear","id_target":2,"id_table":2,"id_field":0,"label":"Clear","id_event":2,"code":"clear()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"back","id_target":2,"id_table":2,"id_field":0,"label":"Back","id_event":2,"code":"go(2,1,''back'')"}');

-- tb_field
insert into tb_event (field) values ('{"id_system":1,"name":"new","id_target":1,"id_table":3,"id_field":0,"label":"New","id_event":2,"code":"go(3,2,''new'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"edit","id_target":1,"id_table":3,"id_field":0,"label":"Edit","id_event":2,"code":"go(3,2,''edit'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"delete","id_target":1,"id_table":3,"id_field":0,"label":"Delete","id_event":2,"code":"go(3,2,''delete'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"save","id_target":2,"id_table":3,"id_field":0,"label":"Confirm","id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"filter","id_target":1,"id_table":3,"id_field":0,"label":"Filter","id_event":2,"code":"go(3,2,''filter'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"clear","id_target":2,"id_table":3,"id_field":0,"label":"Clear","id_event":2,"code":"clear()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"back","id_target":2,"id_table":3,"id_field":0,"label":"Back","id_event":2,"code":"go(3,1,''back'')"}');

-- tb_domain
insert into tb_event (field) values ('{"id_system":1,"name":"new","id_target":1,"id_table":4,"id_field":0,"label":"New","id_event":2,"code":"go(4,2,''new'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"edit","id_target":1,"id_table":4,"id_field":0,"label":"Edit","id_event":2,"code":"go(4,2,''edit'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"delete","id_target":1,"id_table":4,"id_field":0,"label":"Delete","id_event":2,"code":"go(4,2,''delete'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"save","id_target":2,"id_table":4,"id_field":0,"label":"Confirm","id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"filter","id_target":1,"id_table":4,"id_field":0,"label":"Filter","id_event":2,"code":"go(4,2,''filter'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"clear","id_target":2,"id_table":4,"id_field":0,"label":"Clear","id_event":2,"code":"clear()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"back","id_target":2,"id_table":4,"id_field":0,"label":"Back","id_event":2,"code":"go(4,1,''back'')"}');

-- tb_event
insert into tb_event (field) values ('{"id_system":1,"name":"new","id_target":1,"id_table":5,"id_field":0,"label":"New","id_event":2,"code":"go(5,2,''new'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"edit","id_target":1,"id_table":5,"id_field":0,"label":"Edit","id_event":2,"code":"go(5,2,''edit'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"delete","id_target":1,"id_table":5,"id_field":0,"label":"Delete","id_event":2,"code":"go(5,2,''delete'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"save","id_target":2,"id_table":5,"id_field":0,"label":"Confirm","id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"filter","id_target":1,"id_table":5,"id_field":0,"label":"Filter","id_event":2,"code":"go(5,2,''filter'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"clear","id_target":2,"id_table":5,"id_field":0,"label":"Clear","id_event":2,"code":"clear()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"back","id_target":2,"id_table":5,"id_field":0,"label":"Back","id_event":2,"code":"go(5,1,''back'')"}');

-- tb_code
insert into tb_event (field) values ('{"id_system":1,"name":"new","id_target":1,"id_table":6,"id_field":0,"label":"New","id_event":2,"code":"go(6,2,''new'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"edit","id_target":1,"id_table":6,"id_field":0,"label":"Edit","id_event":2,"code":"go(6,2,''edit'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"delete","id_target":1,"id_table":6,"id_field":0,"label":"Delete","id_event":2,"code":"go(6,2,''delete'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"save","id_target":2,"id_table":6,"id_field":0,"label":"Confirm","id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"filter","id_target":1,"id_table":6,"id_field":0,"label":"Filter","id_event":2,"code":"go(6,2,''filter'')"}');
insert into tb_event (field) values ('{"id_system":1,"name":"clear","id_target":2,"id_table":6,"id_field":0,"label":"Clear","id_event":2,"code":"clear()"}');
insert into tb_event (field) values ('{"id_system":1,"name":"back","id_target":2,"id_table":6,"id_field":0,"label":"Back","id_event":2,"code":"go(6,1,''back'')"}');

-- tb_login
insert into tb_event (field) values ('{"id_system":1,"name":"login","id_target":2,"id_table":7,"id_field":0,"label":"Login","id_event":2,"code":"login()"}');

-- -----------------------------------------------------
-- table tb_code
-- -----------------------------------------------------
insert into tb_code (field) values ('{"id_system":1,"code":"function novo() {alert(txt(123));}"}');