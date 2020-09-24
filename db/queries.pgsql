select 
tb_table.id as id_table,
tb_table_function.id,
tb_table_function.field->>'id_profile' as profile,
tb_action.field->>'name' as name
from tb_table_function
inner join tb_table on (tb_table_function.field->>'id_table')::int = tb_table.id 
inner join tb_action on (tb_table_function.field->>'id_function')::int = tb_action.id
inner join tb_profile_table on (tb_profile_table.field->>'id_profile')::int = (tb_table_function.field->>'id_profile')::int 
and (tb_table_function.field->>'id_table')::int = tb_table.id
where tb_table.id = 1
and (tb_table_function.field->>'id_profile')::int = 1
