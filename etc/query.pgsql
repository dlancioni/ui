-- select * from information_schema.tables where table_schema = 's20201'
set search_path to S20201;


select 
count(*) over() as record_count,
(.field->>'id_group')::int as "id_group",
.id
, (.field->>'current')::text as current
, (.field->>'new')::text as new
, (.field->>'confirm')::text as confirm
 from 
 where 1=1
 and (.field->>'id_group')::int in  ( select 1 union select (tb_user_group.field->>'id_grp')::int from tb_user_group where (tb_user_group.field->>'id_user')::int = 3) 
 and .id = 0
 order by id