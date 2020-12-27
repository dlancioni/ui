drop schema if exists empresa cascade;
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
select * from empresa.tb_user;

