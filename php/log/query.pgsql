select json_agg(t) from (select 
count(*) over() as record_count,
(tb_action.field->>'id_group')::int as "id_group",
tb_action.id
, (tb_action.field->>'name')::text as name
 from tb_action
 where (tb_action.field->>'id_system')::text = 'S20201'
 order by tb_action.id
 limit 15
) t