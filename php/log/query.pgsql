select json_agg(t) from (select 
count(*) over() as record_count,
(tb_code.field->>'id_group')::int as "id_group",
tb_code.id
, (tb_code.field->>'comment')::text as comment
, (tb_code.field->>'code')::text as code
 from tb_code
 where (tb_code.field->>'id_system')::text = 'S20201'
 order by tb_code.id
 limit 15
) t