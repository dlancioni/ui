select json_agg(t) from (select 
count(*) over() as record_count,
(tb_table_function.field->>'id_group')::int as "id_group",
tb_table_function.id
, (tb_table_function.field->>'id_profile')::int as id_profile
, (tb_profile_id_profile.field->>'name')::text as "profile"
, (tb_table_function.field->>'id_table')::int as id_table
, (tb_table_id_table.field->>'title')::text as "table"
, (tb_table_function.field->>'id_function')::int as id_function
, (tb_function_id_function.field->>'name')::text as "function"
 from tb_table_function
 left join tb_profile tb_profile_id_profile on (tb_table_function.field->>'id_profile')::text = (tb_profile_id_profile.id)::text
 left join tb_table tb_table_id_table on (tb_table_function.field->>'id_table')::text = (tb_table_id_table.id)::text
 left join tb_function tb_function_id_function on (tb_table_function.field->>'id_function')::text = (tb_function_id_function.id)::text
 where (tb_table_function.field->>'id_system')::text = 'S20201'
 order by tb_table_function.id
 limit 15
) t