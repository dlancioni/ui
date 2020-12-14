set search_path to S20201;

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
, (tb_event.field->>'id_action')::int as id_action
, (tb_action_id_action.field->>'name')::text as "action"
, (tb_event.field->>'id_event')::int as id_event
--, (tb_event_id_event.field->>'value')::text as "event"
, (tb_event.field->>'code')::text as code
 from tb_event
 left join tb_table tb_table_id_table on (tb_event.field->>'id_table')::text = (tb_table_id_table.id)::text
 left join tb_field tb_field_id_field on (tb_event.field->>'id_field')::text = (tb_field_id_field.id)::text
 left join tb_domain tb_target_id_target on (tb_event.field->>'id_target')::text = (tb_target_id_target.field->>'key')::text and (tb_target_id_target.field->>'domain')::text = 'tb_target'
 left join tb_action tb_action_id_action on (tb_event.field->>'id_action')::text = (tb_action_id_action.id)::text
 where 1=1
 and (tb_event.field->>'id_table')::int = 1
) t