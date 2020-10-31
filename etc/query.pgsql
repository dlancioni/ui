




select field->>'title' from system_1.tb_table
where field->>'id_table' = '2' order by id

 select tb_field.id
 from tb_field 
 inner join tb_table on (tb_field.field->>'id_table')::text = (tb_table.id)::text 
 left join tb_field_attribute on (tb_field.field->>'id_table')::text = (tb_field_attribute.field->>'id_table')::text and (tb_field.id)::text = (tb_field_attribute.field->>'id_field')::text left 
 join tb_table tb_table_fk on (tb_field.field->>'id_table_fk')::text = (tb_table_fk.id)::text left 
 join tb_field tb_field_fk on (tb_field.field->>'id_field_fk')::text = (tb_field_fk.id)::text 
 where (tb_field.field->>'id_system')::int = 1 and (tb_field.field->>'id_table')::int = 2 order by tb_field.id


 select * from system_1.tb_123