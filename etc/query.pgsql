set search_path to S20201;

select distinct field->>'id_table' from tb_field 
where field->>'id_table_fk' = '13'
order by field->>'id_table'