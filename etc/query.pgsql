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

select json_agg(t) from (select count(*) over() as record_count,(tb_view.field->>'id_system')::int as id_system,(tb_view.field->>'id_group')::int as id_group,tb_view.id, (tb_view.field->>'name')::text as name, (tb_view.field->>'sql')::text as sql from tb_view where (tb_view.field->>'id_system')::int = 1 and tb_view.id = 1 order by tb_view.id) t



  select tb_table.id from tb_table where (tb_table.field->>'id_system')::int = 1 and (tb_table.field->>'table_name')::text = 'tb_domain'