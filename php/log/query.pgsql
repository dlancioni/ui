select json_agg(t) from (select 
count(*) over() as record_count,
(tb_view_field.field->>'id_system')::text as id_system,
(tb_view_field.field->>'id_group')::int as id_group,
tb_view_field.id
, (tb_view_field.field->>'id_view')::int as id_view
, (tb_view_id_view.field->>'name')::text as view
, (tb_view_field.field->>'id_command')::int as id_command
, (tb_command_id_command.field->>'value')::text as command
, (tb_view_field.field->>'id_table')::int as id_table
, (tb_table_id_table.field->>'title')::text as table
, (tb_view_field.field->>'id_field')::int as id_field
, (tb_field_id_field.field->>'label')::text as field
, (tb_view_field.field->>'id_operator')::int as id_operator
, (tb_operator_id_operator.field->>'value')::text as operator
, (tb_view_field.field->>'value')::text as value
 from tb_view_field
 left join tb_view tb_view_id_view on (tb_view_field.field->>'id_view')::text = (tb_view_id_view.id)::text
 left join tb_domain tb_command_id_command on (tb_view_field.field->>'id_command')::text = (tb_command_id_command.field->>'key')::text and (tb_command_id_command.field->>'domain')::text = 'tb_command'
 left join tb_table tb_table_id_table on (tb_view_field.field->>'id_table')::text = (tb_table_id_table.id)::text
 left join tb_field tb_field_id_field on (tb_view_field.field->>'id_field')::text = (tb_field_id_field.id)::text
 left join tb_domain tb_operator_id_operator on (tb_view_field.field->>'id_operator')::text = (tb_operator_id_operator.field->>'key')::text and (tb_operator_id_operator.field->>'domain')::text = 'tb_operator'
 where (tb_view_field.field->>'id_system')::text = 'S20201'
 order by tb_view_field.id
 limit 15
) t