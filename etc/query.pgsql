



select json_agg(t) from (select count(*) over() as record_count,(tb_field_attribute.field->>'id_system')::int as id_system,(tb_field_attribute.field->>'id_group')::int as id_group,tb_field_attribute.id, (tb_field_attribute.field->>'id_table')::int as id_table, (tb_table_id_table.field->>'name')::text as table, (tb_field_attribute.field->>'id_field')::int as id_field, (tb_field_id_field.field->>'label')::text as field, (tb_field_attribute.field->>'column_size')::int as column_size, (tb_field_attribute.field->>'default_value')::int as default_value, (tb_field_attribute.field->>'table_order')::int as table_order, (tb_field_attribute.field->>'form_order')::int as form_order, (tb_field_attribute.field->>'id_disabled')::int as id_disabled, (id_disabled.field->>'value')::text as disabled, (tb_field_attribute.field->>'id_hidden')::int as id_hidden, (_id_hidden.field->>'value')::text as hidden from tb_field_attribute left join tb_table tb_table_id_table on (tb_field_attribute.field->>'id_table')::text = (tb_table_id_table.id)::text left join tb_field tb_field_id_field on (tb_field_attribute.field->>'id_field')::text = (tb_field_id_field.id)::text left join tb_domain tb_domain_id_disabled on (tb_field_attribute.field->>'id_disabled')::text = (tb_domain_id_disabled.id)::text left join tb_domain tb_domain_id_hidden on (tb_field_attribute.field->>'id_hidden')::text = (tb_domain_id_hidden.id)::text where (tb_field_attribute.field->>'id_system')::int = 1 and (tb_field_attribute.field->>'id_table')::int = 11 order by tb_field_attribute.id) t

