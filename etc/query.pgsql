set search_path to S20201;

select json_agg(t) from (select 
(tb_field.field->>'id_group')::int as "id_group"
, (tb_field.field->>'id_table')::int as id_table
, (tb_table_id_table.field->>'title')::text as "table"
, count((tb_field.field->>'name')::text) as "Total"
 from tb_field
 left join tb_table tb_table_id_table on (tb_field.field->>'id_table')::text = (tb_table_id_table.id)::text
 left join tb_table tb_table_id_table on (tb_field.field->>'id_table')::text = (tb_table_id_table.id)::text
 where 1=1
 group by (tb_field.field->>'id_group')::int
, (tb_field.field->>'id_table')::int
, (tb_table_id_table.field->>'title')::text
, (tb_field.field->>'id_table')::int
, (tb_table_id_table.field->>'title')::text
 order by (tb_field.field->>'id_table')::int asc limit 15
) t