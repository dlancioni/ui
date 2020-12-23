set search_path to S20201;

drop schema demo cascade

select schema_name from information_schema.schemata
select * from home.tb_client