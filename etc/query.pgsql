set search_path to empresa;

select 
count(*) over() as record_count,
(tb_user_profile.field->>'id_group')::int as "id_group",
tb_user_profile.id
, (tb_user_profile.field->>'id_user')::int as id_user
, (tb_user_profile.field->>'id_profile')::int as id_profile
 from tb_user_profile
 where 1=1
 and (tb_user.field->>'username')::text = 'system'
 order by id