



select distinct tb_user_profile.field->>'id_profile' id_profile, tb_function.id, tb_function.field->>'name' as name 
from tb_user_profile 
inner join tb_table_function on (tb_table_function.field->>'id_profile')::int = (tb_user_profile.field->>'id_profile')::int 
inner join tb_function on (tb_table_function.field->>'id_function')::int = tb_function.id 
where (tb_table_function.field->>'id_table')::int = 14 
and (tb_user_profile.field->>'id_user')::int = 1 
order by tb_function.id