select json_agg(t) from (select 
count(*) over() as record_count,
(tb_event.field->>'id_group')::int as "id_group",
tb_event.id
, (tb_event.field->>'id_table')::int as id_table
, (tb_table_id_table.field->>'title')::text as "table"
, (tb_event.field->>'id_field')::int as id_field
, (tb_field_id_field.field->>'label')::text as "field"
, (tb_event.field->>'id_target')::int as id_target
, (tb_target_id_target.field->>'value')::text as "target"
, (tb_event.field->>'id_function')::int as id_function
, (tb_function_id_function.field->>'name')::text as "function"
, (tb_event.field->>'id_event')::int as id_event
, (tb_event_id_event.field->>'value')::text as "event"
, (tb_event.field->>'code')::text as code
 from tb_event
 left join tb_table tb_table_id_table on (tb_event.field->>'id_table')::text = (tb_table_id_table.id)::text
 left join tb_field tb_field_id_field on (tb_event.field->>'id_field')::text = (tb_field_id_field.id)::text
 left join tb_domain tb_target_id_target on (tb_event.field->>'id_target')::text = (tb_target_id_target.field->>'key')::text and (tb_target_id_target.field->>'domain')::text = 'tb_target'
 left join tb_function tb_function_id_function on (tb_event.field->>'id_function')::text = (tb_function_id_function.id)::text
 left join tb_domain tb_event_id_event on (tb_event.field->>'id_event')::text = (tb_event_id_event.field->>'key')::text and (tb_event_id_event.field->>'domain')::text = 'tb_event'
 where (tb_event.field->>'id_system')::text = 'S20201'
 and (tb_event.field->>'id_table')::int = 5
 order by tb_event.id
) t