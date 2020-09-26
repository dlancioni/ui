select 
tb_user_profile.field->>'id_profile' id_profile,
tb_action.id,
tb_action.field->>'name' as name
from tb_user_profile
inner join tb_table_function on 
          (tb_table_function.field->>'id_profile')::int = (tb_user_profile.field->>'id_profile')::int   
inner join tb_action on (tb_table_function.field->>'id_function')::int = tb_action.id
where (tb_table_function.field->>'id_table')::int = 1
and (tb_user_profile.field->>'id_user')::int = 1
order by tb_action.id


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
where (tb_table.field->>'id_system')::int = 1
and (tb_user_profile.field->>'id_user')::int = 1
order by tb_table.field->>'name'