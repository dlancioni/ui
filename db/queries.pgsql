
select 
distinct
tb_table.id,
tb_table.field->>'id_parent' as id_parent,
tb_table.field->>'name' as name,
tb_table.field->>'table_name' as table_name
from tb_table
inner join tb_profile_table on (tb_profile_table.field->>'id_table')::int = tb_table.id
inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id
inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id
where (tb_table.field->>'id_system')::int = p1
and (tb_user_profile.field->>'id_user')::int = p1
order by tb_table.field->>'name'


    --tb_profile.id,
    --tb_profile.field->>'name' as profile_name,
select * from tb_table_function where field->'id_table' = '36'

select * from tb_profile_table where (tb_field.field->>'id_system')::int = 1 and (tb_field.field->>'id_table')::int = 36