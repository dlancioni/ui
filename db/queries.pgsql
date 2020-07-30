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

select json_agg(t) from (select tb_system.id,count(*) over() as record_count, 
(tb_system.field->>'name')::text as name, 
tb_system.field->>'expire_date' as expire_date, 
(tb_system.field->>'price')::float as price 
from tb_system where 1 = 1 order by tb_system.id limit 20) t