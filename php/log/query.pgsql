select json_agg(t) from (select 
count(*) over() as record_count,
(tb_group.field->>'id_group')::int as "id_group",
tb_group.id
, (tb_group.field->>'name')::text as name
 from tb_group
 where (tb_group.field->>'id_system')::text = 'S20201'
 order by tb_group.id
 limit 15
) t