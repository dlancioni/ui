select json_agg(t) from (select 
count(*) over() as record_count,
(tb_domain.field->>'id_group')::int as "id_group",
tb_domain.id
, (tb_domain.field->>'key')::text as key
, (tb_domain.field->>'value')::text as value
, (tb_domain.field->>'domain')::text as domain
 from tb_domain
 where (tb_domain.field->>'id_system')::text = 'S20201'
 order by tb_domain.id
 limit 15
) t