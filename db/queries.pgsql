/*
-- -----------------------------------------------------
-- TB_SYSTEM
-- -----------------------------------------------------
select 
id,
field->>'name' as name,
field->>'price' as price,
field->>'expire_date' as expire_date
from tb_system

-- -----------------------------------------------------
-- TB_TABLE
-- -----------------------------------------------------
select 
id,
field->>'id_system' as id_system,
field->>'name' as name,
field->>'id_type' as id_type,
field->>'title' as title,
field->>'table_name' as table_name
from tb_table

-- -----------------------------------------------------
-- TB_FIELD
-- -----------------------------------------------------
*/

select 
    tb_field.id, 
    (tb_field.field->>'id_table')::int as id_table, 
    (tb_table_id_table.field->>'name')::text as table, 
    (tb_field.field->>'label')::text as label, 
    (tb_field.field->>'name')::text as name, 
    (tb_field.field->>'id_type')::int as id_type, 
    (tb_field_type_id_type.field->>'value')::text as type, 
    (tb_field.field->>'size')::int as size, 
    (tb_field.field->>'mask')::text as mask, 
    (tb_field.field->>'id_mandatory')::int as id_mandatory, 
    (tb_bool_id_mandatory.field->>'value')::text as mandatory, 
    (tb_field.field->>'id_unique')::int as id_unique, 
    (tb_bool_id_unique.field->>'value')::text as unique, 
    (tb_field.field->>'id_table_fk')::int as id_table_fk, 
    (tb_table_id_table_fk.field->>'name')::text as table_fk, 
    (tb_field.field->>'id_field_fk')::int as id_field_fk, 
    (tb_field_id_field_fk.field->>'name')::text as field_fk, 
    (tb_field.field->>'domain')::text as domain 
from tb_field 
left join tb_table tb_table_id_table on (tb_field.field->>'id_table')::int = tb_table_id_table.id 
inner join tb_domain tb_field_type_id_type on (tb_field.field->>'id_type')::text = (tb_field_type_id_type.field->>'key')::text 
    and (tb_field_type_id_type.field->>'domain')::text = 'tb_field_type' 
inner join tb_domain tb_bool_id_mandatory on (tb_field.field->>'id_mandatory')::text = (tb_bool_id_mandatory.field->>'key')::text 
    and (tb_bool_id_mandatory.field->>'domain')::text = 'tb_bool' 
inner join tb_domain tb_bool_id_unique on (tb_field.field->>'id_unique')::text = (tb_bool_id_unique.field->>'key')::text 
    and (tb_bool_id_unique.field->>'domain')::text = 'tb_bool' 
left join tb_table tb_table_id_table_fk on (tb_field.field->>'id_table_fk')::int = tb_table_id_table_fk.id 
left join tb_field tb_field_id_field_fk on (tb_field.field->>'id_field_fk')::int = tb_field_id_field_fk.id 
--where (tb_field.field->>'id_system')::int = 1 
order by tb_field.id



