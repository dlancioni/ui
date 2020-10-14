select distinct 
tb_table.id
from tb_table 
inner join tb_profile_table on (tb_profile_table.field->>'id_table')::int = tb_table.id 
inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id 
inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id 
where (tb_table.field->>'id_system')::int = 1 
and (tb_user_profile.field->>'id_user')::int = 1 
order by tb_table.id

select * from tb_profile
select * from tb_profile_table
select * from tb_table_function
select * from tb_field
select field->'sql' from tb_view

select json_agg(t) from (select count(*) over() as record_count,(tb_event.field->>'id_system')::int as id_system,(tb_event.field->>'id_group')::int as id_group,tb_event.id, (tb_event.field->>'id_target')::int as id_target, (tb_event.field->>'id_table')::int as id_table, (tb_event.field->>'id_field')::int as id_field, (tb_event.field->>'id_function')::int as id_function, (tb_event.field->>'id_event')::int as id_event, (tb_event.field->>'code')::text as code from tb_event where (tb_event.field->>'id_system')::int = 1 and (tb_event.field->>'id_target')::int = 1 and (tb_event.field->>'id_table')::int = 2 order by tb_event.id) t