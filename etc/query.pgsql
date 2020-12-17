set search_path to S20201;



select 
count(*) over() as record_count,
(tb_field.field->>'id_group')::int as "id_group",
tb_field.id
, (tb_field.field->>'id_table')::int as id_table
, (tb_table_id_table.field->>'title')::text as "table"
, (tb_field.field->>'label')::text as label
, (tb_field.field->>'name')::text as name
, (tb_field.field->>'id_type')::text as id_type
, (tb_field_type_id_type.field->>'value')::text as "type"
, (tb_field.field->>'size')::int as size
, (tb_field.field->>'mask')::text as mask
, (tb_field.field->>'id_mandatory')::int as id_mandatory
, (tb_bool_id_mandatory.field->>'value')::text as "mandatory"
, (tb_field.field->>'id_unique')::int as id_unique
, (tb_bool_id_unique.field->>'value')::text as "unique"
, (tb_field.field->>'id_table_fk')::int as id_table_fk
, (tb_table_id_table_fk.field->>'title')::text as "table_fk"
, (tb_field.field->>'id_field_fk')::int as id_field_fk
, (tb_field_id_field_fk.field->>'label')::text as "field_fk"
, (tb_field.field->>'domain')::text as domain
, (tb_field.field->>'default_value')::text as default_value
, (tb_field.field->>'id_control')::int as id_control
, (tb_control_id_control.field->>'value')::text as "control"
, (tb_field.field->>'ordenation')::int as ordenation
 from tb_field
 left join tb_table tb_table_id_table on (tb_field.field->>'id_table')::text = (tb_table_id_table.id)::text
 left join tb_domain tb_field_type_id_type on (tb_field.field->>'id_type')::text = (tb_field_type_id_type.field->>'key')::text and (tb_field_type_id_type.field->>'domain')::text = 'tb_field_type'
 left join tb_domain tb_bool_id_mandatory on (tb_field.field->>'id_mandatory')::text = (tb_bool_id_mandatory.field->>'key')::text and (tb_bool_id_mandatory.field->>'domain')::text = 'tb_bool'
 left join tb_domain tb_bool_id_unique on (tb_field.field->>'id_unique')::text = (tb_bool_id_unique.field->>'key')::text and (tb_bool_id_unique.field->>'domain')::text = 'tb_bool'
 left join tb_table tb_table_id_table_fk on (tb_field.field->>'id_table_fk')::text = (tb_table_id_table_fk.id)::text
 left join tb_field tb_field_id_field_fk on (tb_field.field->>'id_field_fk')::text = (tb_field_id_field_fk.id)::text
 left join tb_domain tb_control_id_control on (tb_field.field->>'id_control')::text = (tb_control_id_control.field->>'key')::text and (tb_control_id_control.field->>'domain')::text = 'tb_control'
 where 1=1
 and (tb_field.field->>'id_table_fk')::int = 2
