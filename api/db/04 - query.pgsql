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
select
tb_field.id,
(tb_field.field->>'id_system')::int as id_system,
(tb_table.field->>'table_name')::text as table_name,
(tb_field.field->>'label')::text as field_label,
(tb_field.field->>'name')::text as field_name,
(tb_field.field->>'id_type')::int as field_type,
(tb_field.field->>'size')::int as field_size,
(tb_field.field->>'mask')::text as field_mask,
(tb_field.field->>'id_mandatory')::int as field_mandatory,
(tb_field.field->>'id_unique')::int as field_unique,
(tb_field.field->>'id_fk')::int as field_fk,
(tb_field.field->>'domain')::text as field_domain
from tb_field
inner join tb_table on (tb_field.field->>'id_table')::int = tb_table.id
where (tb_field.field->>'id_table')::int = 3