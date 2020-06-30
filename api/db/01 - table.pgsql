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
-- table tb_menu
-- -----------------------------------------------------
drop table if exists tb_menu cascade;
create table if not exists tb_menu (id serial, field jsonb);

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
-- table tb_catalog
-- -----------------------------------------------------
drop table if exists tb_catalog cascade;
create table if not exists tb_catalog (id serial, field jsonb);