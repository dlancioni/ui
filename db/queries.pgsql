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
 

select tb_table.id, (tb_table.field->>'id_system')::int as id_system, (tb_system_id_system.field->>'name')::text as system, (tb_table.field->>'name')::text as name, (tb_table.field->>'id_type')::int as id_type, (tb_table_type_id_type.field->>'value')::text as type, (tb_table.field->>'title')::text as title from tb_table left join tb_system tb_system_id_system on (tb_table.field->>'id_system')::int = tb_system_id_system.id inner join tb_domain tb_table_type_id_type on (tb_table.field->>'id_type')::text = (tb_table_type_id_type.field->>'key')::text and (tb_table_type_id_type.field->>'domain')::text = 'tb_table_type' 
where (tb_table.field->>'id_system')::int = 1 and (tb_table.field->>'id_system')::int = 1 
and (tb_table.field->>'name')::text = 3 and (tb_table.field->>'id_type')::int = 1 
and (tb_table.field->>'title')::text = 3 
order by tb_table.id