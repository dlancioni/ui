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
select
tb_field.id,
(tb_field.field->>'id_system')::int as id_system,
(tb_table.field->>'name')::text as table_name,
(tb_field.field->>'label')::text as field_label,
(tb_field.field->>'name')::text as field_name,
(tb_field.field->>'id_type')::int as field_type,
(tb_field.field->>'size')::int as field_size,
(tb_field.field->>'mask')::text as field_mask,
(tb_field.field->>'id_mandatory')::int as field_mandatory,
(tb_field.field->>'id_unique')::int as field_unique,
(tb_field.field->>'id_table_fk')::int as id_fk,
(tb_table_fk.field->>'name')::text as table_fk,
(tb_field_fk.field->>'name')::text as field_fk,
(tb_field.field->>'domain')::text as field_domain,
case 
    when (tb_field.field->>'id_type')::int = 1 then 'int'
    when (tb_field.field->>'id_type')::int = 2 then 'float'
    when (tb_field.field->>'id_type')::int = 3 then 'text'
    when (tb_field.field->>'id_type')::int = 4 then 'date'
    when (tb_field.field->>'id_type')::int = 5 then 'boolean'
end data_type  
from tb_field
inner join tb_table on (tb_field.field->>'id_table')::int = tb_table.id
left join tb_table tb_table_fk on (tb_field.field->>'id_table_fk')::int = tb_table_fk.id
left join tb_field tb_field_fk on (tb_field.field->>'id_field_fk')::int = tb_field_fk.id
where (tb_field.field->>'id_system')::int = 1
and (tb_field.field->>'id_table')::int = 3
order by tb_field.id
*/

select
tb_field.id,
(tb_field.field->>'id_system')::int as id_system,
(tb_table.field->>'name')::text as table_name,
(tb_field.field->>'label')::text as field_label,
(tb_field.field->>'name')::text as field_name,
(tb_field.field->>'id_type')::int as field_type,
(tb_field.field->>'size')::int as field_size,
(tb_field.field->>'mask')::text as field_mask,
(tb_field.field->>'id_mandatory')::int as field_mandatory,
(tb_field.field->>'id_unique')::int as field_unique,
(tb_field.field->>'id_table_fk')::int as id_fk,
(tb_table_fk.field->>'name')::text as table_fk,
(tb_field_fk.field->>'name')::text as field_fk,
(tb_field.field->>'domain')::text as field_domain,
case 
    when (tb_field.field->>'id_type')::int = 1 then 'int'
    when (tb_field.field->>'id_type')::int = 2 then 'float'
    when (tb_field.field->>'id_type')::int = 3 then 'text'
    when (tb_field.field->>'id_type')::int = 4 then 'date'
    when (tb_field.field->>'id_type')::int = 5 then 'boolean'
end data_type  
from tb_field
inner join tb_table on (tb_field.field->>'id_table')::int = tb_table.id
left join tb_table tb_table_fk on (tb_field.field->>'id_table_fk')::int = tb_table_fk.id
left join tb_field tb_field_fk on (tb_field.field->>'id_field_fk')::int = tb_field_fk.id
where (tb_field.field->>'id_system')::int = 1
and (tb_field.field->>'id_table')::int = 3
order by tb_field.id






select 
tb_field.id, 
(tb_table_id_table.field->>'name')::text as id_table, 
(tb_field.field->>'label'):: as label, 
(tb_field.field->>'name'):: as name, 
(value_id_type.field->>'value')::text as id_type, 
(tb_field.field->>'size'):: as size, 
(tb_field.field->>'mask'):: as mask, 
(value_id_mandatory.field->>'value')::text as id_mandatory, 
(value_id_unique.field->>'value')::text as id_unique, 
(tb_table_id_table_fk.field->>'name')::text as id_table_fk, 
(tb_field_id_field_fk.field->>'name')::text as id_field_fk, 
(tb_field.field->>'domain')::text as domain, 
(tb_field.field->>'name')::text as name 
from tb_field 
inner join tb_table name_id_table on (tb_field.field->>'id_table')::text = (name_id_table.field->>'key')::text 
and (name_id_table.field->>'domain')::text = 'name' 
inner join tb_domain value_id_type on (tb_field.field->>'id_type')::text = (value_id_type.field->>'key')::text and (value_id_type.field->>'domain')::text = 'value' 
inner join tb_domain value_id_mandatory on (tb_field.field->>'id_mandatory')::text = (value_id_mandatory.field->>'key')::text and (value_id_mandatory.field->>'domain')::text = 'value' 
inner join tb_domain value_id_unique on (tb_field.field->>'id_unique')::text = (value_id_unique.field->>'key')::text and (value_id_unique.field->>'domain')::text = 'value' 
inner join tb_table name_id_table_fk on (tb_field.field->>'id_table_fk')::text = (name_id_table_fk.field->>'key')::text and (name_id_table_fk.field->>'domain')::text = 'name' 
inner join tb_field name_id_field_fk on (tb_field.field->>'id_field_fk')::text = (name_id_field_fk.field->>'key')::text and (name_id_field_fk.field->>'domain')::text = 'name' 
where (tb_field.field->>'id_system')::int = 1 order by tb_field.id
