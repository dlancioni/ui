drop schema if exists demo cascade;
drop schema if exists home cascade;
create schema home;
create table home.tb_client (
    id serial,
    name varchar(50) not null,
    email varchar(50) not null,
    id_system varchar(50) not null,
    expire_date date
);
select * from home.tb_client;
-- select field->>'username', field->>'password' from demo.tb_user;

