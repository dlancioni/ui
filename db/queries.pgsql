select json_agg(t) from (select tb_table.id,count(*) over() as record_count, (tb_table.field->>'id_system')::int as id_system, (tb_system_id_system.field->>'name')::text as system, (tb_table.field->>'id_type')::int as id_type, 
(tb_table_type_id_type.field->>'value')::text as type, 
(tb_table.field->>'name')::text as name, 
(tb_table.field->>'table_name')::text as table_name, 
(tb_table.field->>'id_parent')::int as id_parent, 
(tb_table_id_parent.field->>'name')::text as parent 
left join tb_system tb_system_id_system on (tb_table.field->>'id_system')::text = (tb_system_id_system.id)::text 
inner join tb_domain tb_table_type_id_type on (tb_table.field->>'id_type')::text = (tb_table_type_id_type.field->>'key')::text and (tb_table_type_id_type.field->>'domain')::text = 'tb_table_type' 
left join tb_table tb_table_id_parent on (tb_table.field->>'id_parent')::text = (tb_table_id_parent.id)::text where (tb_table.field->>'id_system')::int = 1) t
