select json_agg(t) from (select 
count(*) over() as record_count,
(tb_profile.field->>'id_group')::int as "id_group",
tb_profile.id
, (tb_profile.field->>'name')::text as name
 from tb_profile
 where (tb_profile.field->>'id_system')::text = 'S20201'
 order by tb_profile.id
 limit 15
) t