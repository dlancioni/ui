 select
 tb_field.id,
 (tb_field.field->>'id_system')::text as id_system,
 (tb_table.field->>'name')::text as table_name,
 (tb_table.field->>'title')::text as title,
 (tb_table.field->>'id_view')::text as id_view,
 (tb_field.field->>'label')::text as field_label,
 (tb_field.field->>'name')::text as field_name,
 (tb_field.field->>'id_type')::text as field_type,
 (tb_field.field->>'size')::int as field_size,
 (tb_field.field->>'mask')::text as field_mask,
 (tb_field.field->>'id_mandatory')::int as field_mandatory,
 (tb_field.field->>'id_unique')::int as field_unique,
 (tb_field.field->>'id_table_fk')::int as id_fk,
 (tb_table_fk.field->>'name')::text as table_fk,
 (tb_field_fk.field->>'name')::text as field_fk,
 (tb_field.field->>'domain')::text as field_domain,
 (tb_field.field->>'default_value')::text as default_value,
 (tb_field.field->>'ordenation')::text as ordenation,
 (tb_field.field->>'id_control')::text as id_control
 from tb_field
 inner join tb_table on (tb_field.field->>'id_table')::text = (tb_table.id)::text
 left join tb_table tb_table_fk on (tb_field.field->>'id_table_fk')::text = (tb_table_fk.id)::text
 left join tb_field tb_field_fk on (tb_field.field->>'id_field_fk')::text = (tb_field_fk.id)::text
 where (tb_field.field->>'id_system')::text = 'S20201'
 and (tb_field.field->>'id_table')::int = 4
 order by (tb_field.field->>'ordenation')::int, tb_field.id
