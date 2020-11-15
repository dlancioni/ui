

delete from home.tb_client;
select * from home.tb_client;


set search_path to S20201;
select id, field->>'name' as name, count(*) over() as record_count 
 from tb_menu 